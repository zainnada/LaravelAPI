<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AuthorTicketsController extends ApiController
{
    public function index($author_id, TicketFilter $filter)
    {
        return TicketResource::collection(Ticket::where('user_id',$author_id)->filter($filter)->paginate());
    }
    public function store($author_id, StoreTicketRequest $request)
    {
        try {
            $user = User::findOrFail($request->input('data.relationships.author.data.id'));
        } catch (ModelNotFoundException $exception) {
            return $this->ok('User not found',[
                'error' => 'The provided user id does not exist.'
            ]);
        }
        $model = [
            'title' => $request->input('data.attributes.title'),
            'description' => $request->input('data.attributes.description'),
            'status' => $request->input('data.attributes.status'),
            'user_id' => $author_id,
        ];
        return new TicketResource(Ticket::create($model));
    }

    public function show($author_id, $ticket_id){
        try {
            $ticket = Ticket::findOrFail($ticket_id);
            if ($ticket->user_id == $author_id) {
                return new TicketResource($ticket->load('author'));
            }
            return $this->error('Unauthorized',403);
        }catch (ModelNotFoundException $exception) {
            return $this->error('Ticket cannot be found.',404);
        }
    }
    public function destroy($author_id, $ticket_id){
        try {
            $ticket = Ticket::findOrFail($ticket_id);
            if ($ticket->user_id == $author_id) {
                $ticket->delete();
                return $this->ok('Authors\' Ticket has been deleted');
            }
                return $this->error('Unauthorized',403);

        } catch (ModelNotFoundException $exception) {
            return $this->error('Ticket cannot be found.',404);
        }
    }

}
