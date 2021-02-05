<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\House;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AddHouseRequest;
use Illuminate\Support\Facades\Session;

class HouseController extends Controller
{
    public function formAddHouse()
    {
        $categories = Category::all();
        return view('house.add-house', compact('categories'));
    }

    public function store(Request $request)
    {
        $house = new House();
        $house->fill($request->all());
        $house->status = StatusConst::LEASE;
        $house->user_id = Auth::id();

        //upload file
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('houses', 'public');
            $house->image = $path;
        }

        $house->save();
        if ($request->hasFile('image_detail')) {
            $imageDetail = $request->file('image_detail');
            foreach ($imageDetail as $img) {
                $path = $img->store('houses', 'public');
                $image = new Image();
                $image->image = $path;
                $image->house_id = $house->id;
                $image->save();
            }
        }
        toastr()->success('Đăng nhà cho thuê thành công!');
        return redirect()->route('home');
    }

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): \Illuminate\Http\Response
    {
        $house = House::find($id);
        $house->images()->delete();
        $house->delete();
        Session::flash('delete_success', 'Delete Success!');
        return back();
    }

    public function search(Request $request)
    {
        $result = House::query();

        if ($request->keyword){
            $result = $result->where('address', 'like', '%'.$request->keyword.'%');
        }

        if ($request->type != 0){
            $result = $result->where('category_id', '=', $request->type);
        }


        if ($request->min_price) {
            $result = $result->where('pricePerDay', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $result = $result->where('pricePerDay', '<=', $request->max_price);
        }

        if ($request->tab != 0) {
            $result = $result->where('status', '=', $request->tab);
        }

        $houses = $result->get();
        return view('house.search', compact('houses'));
    }


    public function showDetail($id)
    {
        $house = House::find($id);
        $user = User::find($house->user_id);
        return view('house.show-infor', compact('house', 'user'));
    }

    public function listHouse()
    {
        $houses = House::all();
        $users = User::all();
        return view('house.list-house', compact('houses', 'users'));
    }

    public function showHouse($id)
    {
        $house = House::find($id);
        $categories = Category::all();
        return view('house.edit-house', compact('house', 'categories'));
    }
    public function updateHouse(Request $request)
    {
        $id = $request->input('id');
        $house = House::find($id);
        $house->fill($request->all());
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('images', 'public');
            $house->image = $path;
        }
        $house->save();
        toastr()->success('Cập nhật thành công!!!');
        return redirect()->route('me.getListHouseOfUser', $id);
    }
}
