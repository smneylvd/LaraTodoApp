<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $is_admin = $request->get('id_admin', false);

        $items = Task::query()
            ->where('deleted_at', null)
            ->where(function ($q) use ($is_admin, $request) {
                if (!$is_admin) {
                    $q->where('user_id', $request->user()->id);
                }
                if ($title = $request->get('title')) {
                    $q->where('title', 'like', "%$title%");
                }
                if ($description = $request->get('description')) {
                    $q->where('description', 'like', "%$description%");
                }
                if ($statusSlug = $request->get('status')) {
                    $q->whereHas("status", function ($q) use ($statusSlug) {
                        $q->where('slug', $statusSlug);
                    });
                }
            })
            ->paginate($request->get('per_page', 12));

        return response()->json([
                'items' => $items->items(),
                'total' => $items->total(),
                'current_page' => $items->currentPage(),
                'total_pages' => $items->lastPage()
            ]
        );
    }

    public function view($item)
    {
        return response()->json(Task::where('deleted_at', null)->where('id', $item)->get());
    }

    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'title' => 'required',
            'description' => 'required',
            'status_id' => ''
        ]);

        if ($validator->fails()) {
            throw new HttpException(400, $validator->errors()->first());
        }

        $title = $request->get('title');
        $description = $request->get('description');
        $deadline = $request->get('deadline');
        $deadline = $deadline ? Carbon::parse($deadline) : null;
        $status_id = $request->get('status_id', -1);

        $status = Status::where('deleted_at', null)
            ->where('id', $status_id)
            ->first();

        if (!$status) {
            $status = Status::where('deleted_at', null)
                ->firstOrFail();
        }


        $item = new Task();
        $item->title = $title;
        $item->description = $description;
        $item->status_id = $status->id;
        $item->user_id = Auth::user()->id;
        $item->created_at = Carbon::now();
        $item->deadline = $deadline;

        $item->save();

        return response()->json($item);
    }

    public function update(Request $request, $item)
    {
        $item = Task::where('deleted_at', null)
            ->where('id', $item)
            ->firstOrFail();

        $validator = Validator::make(request()->all(), [
            'title' => 'required',
            'description' => 'required',
            'status_id' => ''
        ]);

        if ($validator->fails()) {
            throw new HttpException(400, $validator->errors()->first());
        }

        $status_id = $request->get('status_id', -1);
        $status = Status::where('deleted_at', null)
            ->where('id', $status_id)
            ->first();

        $title = $request->get('title');
        $description = $request->get('description');

        $item->title = $title;
        $item->description = $description;
        $item->status_id = optional($status)->id ?? $item->status_id;
        $item->updated_at = Carbon::now();
        $item->save();

        return response()->json($item);
    }

    public function delete($item)
    {
        $item = Task::where('deleted_at', null)
            ->where('id', $item)
            ->firstOrFail();
        $item->deleted_at = Carbon::now();
        $item->save();

        return response()->json("deleted successfully");
    }
}
