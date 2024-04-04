<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\HttpException;

class StatusController extends Controller
{
    public function index()
    {
        return response()->json(Status::where('deleted_at', null)->get());
    }

    public function view($item)
    {
        return response()->json(Status::where('deleted_at', null)->where('id', $item)->get());
    }

    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'title' => 'required',
            'slug' => 'unique:statuses|required',
        ]);

        if ($validator->fails()) {
            throw new HttpException(400, $validator->errors()->first());
        }
        $title = $request->get('title');
        $slug = $request->get('slug');
        $item = new Status();
        $item->title = $title;
        $item->slug = $slug;
        $item->created_at = Carbon::now();
        $item->save();

        return response()->json($item);
    }

    public function update(Request $request, $item)
    {
        $item = Status::where('deleted_at', null)
            ->where('id', $item)
            ->firstOrFail();

        $validator = Validator::make(request()->all(), [
            'title' => 'required',
            'slug' => [
                'required',
                Rule::unique('statuses', 'slug')
                    ->where(function ($q) {
                        $q->where('deleted_at', '=', null);
                    })
                    ->ignore($item->id)
            ],
        ]);

        if ($validator->fails()) {
            throw new HttpException(400, $validator->errors()->first());
        }

        $title = $request->get('title');
        $slug = $request->get('slug');
        $item->title = $title;
        $item->slug = $slug;
        $item->updated_at = Carbon::now();
        $item->save();

        return response()->json($item);
    }

    public function delete($item)
    {
        $item = Status::where('deleted_at', null)
            ->where('id', $item)
            ->firstOrFail();
        $item->deleted_at = Carbon::now();
        $item->save();

        return response()->json("deleted successfully");
    }
}
