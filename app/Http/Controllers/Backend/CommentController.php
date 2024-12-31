<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\FundraiserPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CommentController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminAllComments(Request $request) {
        $fundposts = FundraiserPost::select('id', 'title')
            ->whereIn('status', ['running', 'completed', 'block'])
            ->get();
        return view('backend.comments.index', compact('fundposts'));
    }

    public function adminAllCommentsDataTable(Request $request) {

        $comments = Comment::with('fundraiserpost');

        if ($request->all()) {
            $comments->where(function ($query) use ($request) {
                if ($request->title) {
                    $query->where('fundraiser_post_id', '=', $request->title);
                }
                if ($request->status) {
                    $query->where('status', '=', $request->status);
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

        return DataTables::of($comments)

            ->addColumn('author', function ($comments) {
                return $comments->name . "<br>" . $comments->email;

            })
            ->editColumn('campaign', function ($comments) {
                return '<a href="' . route('dashboard.fundraiser.campaign.campaign.show', $comments->fundraiserpost->slug) . '" target="_blank">' . Str::limit($comments->fundraiserpost->title, 20, '...') . '</a>';
            })
            ->editColumn('admin_view', function ($comments) {
                return $comments->admin_view == 0 ? 'unread' : 'read';
            })
            ->editColumn('created_at', function ($comments) {
                return $comments->created_at->format('M d, Y');
            })
            ->addColumn('action_column', function ($comments) {
                $statusbg = $comments->status === 'blocked' ? 'bg-success' : 'bg-danger';
                $btnText  = $comments->status === 'blocked' ? 'Active' : 'Block';
                $links    = '<div class="text-end"><a href="' . route('dashboard.campaign.comment.admin.comment.show', $comments->id) . '" class="btn btn-sm btn-primary">View</a><a href="' . route('dashboard.campaign.comment.admin.comment.status.update', $comments->id) . '" class="btn btn-sm text-white ' . $statusbg . '">' . $btnText . '</a></div>';

                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function show(Comment $comment) {
        $comment->update([
            'admin_view' => 1,
        ]);
        return view('backend.comments.show', compact('comment'));
    }

    /**
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function statusUpdate(Comment $comment) {

        if ($comment->status == 'blocked') {
            $comment->update([
                'status' => 'unapproved',
            ]);
        } else {
            $comment->update([
                'status' => 'blocked',
            ]);
        }

        return back()->with('success', 'Status Update Successfull!');

    }
}
