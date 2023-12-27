<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'judul_tiket' => 'required',
            'tipe_tiket' => 'required|in:Task,Bug',
            'assigned_to' => 'required|in:Anggit,Tri,Banu',
            'description' => 'required',
            'label' => 'required|in:To Do,Doing,Testing,Done',
            'project_name' => 'required|in:ECare Phase 2,ECare Phase 3',
        ]);

        // Dapatkan indeks terakhir untuk label tertentu
        $lastIndex = Ticket::where('label', $request->input('label'))
            ->max('index') ?? 0;

        // Hitung indeks berikutnya
        $newIndex = $lastIndex + 1;

        // Buat tiket baru
        $ticket = Ticket::create([
            'no_tiket' => 'T' . time(),
            'judul_tiket' => $request->input('judul_tiket'),
            'tipe_tiket' => $request->input('tipe_tiket'),
            'assigned_to' => $request->input('assigned_to'),
            'description' => $request->input('description'),
            'label' => $request->input('label'),
            'project_name' => $request->input('project_name'),
            'index' => $newIndex,
        ]);

        return response()->json(['message' => 'Ticket created successfully', 'ticket' => $ticket], 201);
    }


    public function getTicketsByLabel()
    {
        
        $todo = Ticket::where('label', 'To Do')->orderBy('index')->get();
        $doing = Ticket::where('label', 'Doing')->orderBy('index')->get();
        $testing = Ticket::where('label', 'Testing')->orderBy('index')->get();
        $done = Ticket::where('label', 'Done')->orderBy('index')->get();

        $response = [
            'todo' => [
                'name' => 'To Do',
                'items' => $todo->toArray(),
            ],
            'doing' => [
                'name' => 'Doing',
                'items' => $doing->toArray(),
            ],
            'testing' => [
                'name' => 'Testing',
                'items' => $testing->toArray(),
            ],
            'done' => [
                'name' => 'Done',
                'items' => $done->toArray(),
            ],
        ];

        return response()->json($response);
    }


    public function dragTickets(Request $request){
        $ticket = Ticket::find($request->id);
        $currentIndex = $ticket->index;

        Ticket::where('label', $ticket->label)
            ->where('index', '>', $currentIndex)
            ->decrement('index');

        Ticket::where('label', $request->label)
            ->where('index', '>=', $request->newIndex) // Menggunakan indeks baru dari FE
            ->increment('index');


        $ticket->label = $request->label;
        $ticket->index = $request->newIndex;
        $ticket->save();

        return response()->json(['message' => 'Update ticket successfully'], 201);

    }
}
