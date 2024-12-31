<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\FundraiserPost;
use App\Models\FundraiserUpdateMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class UpdateMessageController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminAllMessage() {
        $fundposts = FundraiserPost::select('id', 'title')
            ->whereIn('status', ['running', 'completed', 'block'])
            ->get();
        return view('backend.update_message.index', compact('fundposts'));
    }

    public function adminAllCommentsDataTable(Request $request) {
        $messages = FundraiserUpdateMessage::with('fundraiserpost:id,title,user_id,slug');

        if ($request->all()) {
            $messages->where(function ($query) use ($request) {
                if ($request->title) {
                    $query->where('fundraiser_post_id', '=', $request->title);
                }
                if ($request->status) {
                    $status = $request->status == 'active' ? 1 : 2;
                    $query->where('status', '=', $status);
                }
                if ($request->admin_view) {
                    $admin_view = $request->admin_view == 'read' ? 1 : 0;
                    $query->where('admin_view', '=', $admin_view);
                }
                if ($request->fromdate) {
                    $from_date = date("Y-m-d", strtotime($request->fromdate));
                    $query->where('created_at', '>=', $from_date);
                }
                if ($request->todate) {
                    $to_date = date("Y-m-d", strtotime($request->todate));
                    $query->where('created_at', '<=', $to_date);
                }
            });
        }
        return DataTables::of($messages)

            ->editColumn('message', function ($messages) {
                return Str::limit($messages->message, 50, '...');
            })
            ->editColumn('campaign', function ($messages) {
                return '<a href="' . route('dashboard.fundraiser.campaign.campaign.show', $messages->fundraiserpost->slug) . '" target="_blank">' . Str::limit($messages->fundraiserpost->title, 20, '...') . '</a>';
            })
            ->editColumn('status', function ($messages) {
                return $messages->status == 1 ? 'Active' : 'blocked';
            })
            ->editColumn('admin_view', function ($messages) {
                return $messages->admin_view == 0 ? 'unread' : 'read';
            })
            ->editColumn('created_at', function ($messages) {
                return $messages->created_at->format('M d, Y');
            })
            ->addColumn('action', function ($messages) {
                $btnBg  = $messages->status == 1 ? 'bg-danger' : 'bg-success';
                $btnTex = $messages->status == 1 ? 'Block' : 'Active';
                return '<div class="text-end"><a href="' . route('dashboard.campaign.message.admin.message.show', $messages->id) . '" class="btn btn-sm btn-primary">View</a><a href="' . route('dashboard.campaign.message.admin.message.status.update', $messages->id) . '" class="btn btn-sm text-white ' . $btnBg . '">' . $btnTex . '</a></div>';
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function show($id) {
        $message = FundraiserUpdateMessage::with('fundraiserpost:id,title,user_id')->find($id);
        if ($message->admin_view != 1) {
            $message->update([
                'admin_view' => 1,
            ]);
        }

        return view('backend.update_message.show', compact('message'));
    }

    /**
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function statusUpdate($id) {

        $message = FundraiserUpdateMessage::find($id);
        if ($message->status == 1) {
            $message->update([
                'status' => 2,
            ]);
        } else {
            $message->update([
                'status' => 1,
            ]);
        }

        return back()->with('success', 'Status Update Successfull!');

    }
}
