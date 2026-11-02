<?php

namespace App\Http\Controllers\Admin;

use App\Models\Instruction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InstructionController extends Controller
{
    public function index()
    {
        $items = Instruction::orderBy('id', 'desc')
            ->get();

        return view('admin.instructions.index', [
            'items' => $items,
        ]);
    }


    public function create()
    {
        return view('admin.instructions.create');
    }


    public function store(Request $request)
    {
        $item = Instruction::create($request->all());

        return redirect()
            ->to(route('admin.instructions'));
    }


    public function edit($id)
    {
        $item = Instruction::findOrFail($id);

        return view('admin.instructions.edit', [
            'item' => $item,
        ]);
    }


    public function update(Request $request, $id)
    {
        $item = Instruction::findOrFail($id);
        $item->update($request->all());

        return redirect()
            ->to(route('admin.instructions'));
    }


    public function destroy(Request $request, $id)
    {
        $item = Instruction::findOrFail($id);
        $item->delete();

        return redirect()
            ->to(route('admin.instructions'));
    }
}
