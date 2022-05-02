<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PhoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $phones = Phone::all();

        if ($request->hasAny(['name', 'mobile'])) {
            if ($request->filled('name') || $request->filled('mobile')) {
                $phones = Phone::where('firstname', $request->name)
                    ->orWhere('lastname', $request->name)
                    ->orWhere('mobile', $request->mobile)
                    ->get();
            }
        }

        return Inertia::render('Home', ['phones' => $phones]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $open = fopen($request->file, "r");

        $data = fgetcsv($open);
        $array = [];
        //csv row count limit is 1000 can be update
        while (($data = fgetcsv($open, 1000, ",")) !== false) {
            $array[] = $data;
            Phone::create([
                'title' => $data[$request->title],
                'firstname' => $data[$request->firstname],
                'lastname' => $data[$request->lastname],
                'mobile' => $data[$request->mobile],
                'company' => $data[$request->company]
            ]);
        }

        fclose($open);

        return redirect()
            ->back()
            ->with(['message' => 'Import success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Phone  $phone
     * @return \Illuminate\Http\Response
     */
    public function show(Phone $phone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Phone  $phone
     * @return \Illuminate\Http\Response
     */
    public function edit(Phone $phone)
    {
        return Inertia::render('Edit', ['phone' => $phone]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Phone  $phone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Phone $phone)
    {
        $phone->fill($request->all())->save();

        return redirect()->route('phone.index')->with(['message' => 'update success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Phone  $phone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Phone $phone)
    {
        $phone->delete();

        return redirect()->route('phone.index')->with(['message' => 'delete success']);
    }
}
