<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FundraiserPost;
use App\Models\FundraiserUpdateMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class FundraiserUpdateMessageController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        // $posts     = FundraiserPost::where('user_id', auth()->user()->id)->get(['id', 'title']);
        $fundposts = FundraiserPost::select('id', 'title')->where('user_id', Auth::id())->where('status', 'running')->get();

        return view('frontend.post_message.index', compact('fundposts'));
    }

    public function listDataTable(Request $request) {
        $messages = FundraiserUpdateMessage::with('fundraiserpost:id,title,user_id')->where('user_id', auth()->user()->id);

        if ($request->all()) {
            $messages->where(function ($query) use ($request) {
                if ($request->title) {
                    $query->where('fundraiser_post_id', '=', $request->title);
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
            ->editColumn('title', function ($messages) {
                return Str::limit($messages->fundraiserpost->title, 20, '...');
            })
            ->editColumn('created_at', function ($messages) {
                return $messages->created_at->format('M d, Y');
            })
            ->editColumn('updated_at', function ($messages) {
                return $messages->updated_at->format(' M d, Y');
            })
            ->editColumn('status', function ($messages) {
                $status = $messages->status == 1 ? 'Active' : 'blocked';
                return $status . "<br>" . $messages->status == 2 ? "By admin" : '';
            })
            ->addColumn('action', function ($messages) {
                return '<div class="text-end"><a href="' . route('fundraiser.post.message.edit', $messages->id) . '"
                class="action_icon" title="View">
                <i class="fas fa-eye"></i>
                </a><a href="' . route('fundraiser.post.message.edit', $messages->id) . '"
                        class="action_icon" title="Edit">
                        <i class="fas fa-edit"></i>
                        </a>
                        <form action="' . route('fundraiser.post.message.delete', $messages->id) . '"
                        method="POST" class="d-inline" style="cursor: pointer">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <input type="hidden" name="_method" value="DELETE">
                        <p class="action_icon delete message_delete" title="Delete">
                            <i class="fas fa-trash"></i>
                        </p>
                        </form></div>';
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->validate([
            'fundraiser_post' => 'required',
            'update_message'  => 'required|max:500',
        ], [
            'fundraiser_post.required' => 'Select Fundraiser Post',
            'update_message.required'  => 'Enter Fundraiser Message',
        ]);

        FundraiserUpdateMessage::create([
            'user_id'            => auth()->user()->id,
            'fundraiser_post_id' => $request->fundraiser_post,
            'message'            => $request->update_message,
            'message_type'       => 'success',
        ]);

        return response()->json(['success' => 'Message Insert Successfull!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FundraiserUpdateMessage  $fundraiserUpdateMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(FundraiserUpdateMessage $fundraiserupdatemessage) {
        if ($fundraiserupdatemessage->user_id != Auth::id()) {
            abort(404);
        }
        $posts = FundraiserPost::where('user_id', auth()->user()->id)->where('status', 'running')->get(['id', 'title']);

        return view('frontend.post_message.edit', compact('fundraiserupdatemessage', 'posts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FundraiserUpdateMessage  $fundraiserUpdateMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FundraiserUpdateMessage $fundraiserupdatemessage) {
        if ($fundraiserupdatemessage->user_id != Auth::id()) {
            abort(404);
        }
        $request->validate([
            'fundraiser_post' => 'required',
            'update_message'  => 'required|max:500',
        ], [
            'fundraiser_post.required' => 'Select Fundraiser Post',
            'update_message.required'  => 'Enter Fundraiser Message',
        ]);

        $update = $fundraiserupdatemessage->update([
            'fundraiser_post_id' => $request->fundraiser_post,
            'message'            => $request->update_message,
        ]);
        if ($update) {
            return redirect()->route('fundraiser.post.message.index')->with('success', 'Update Successfull!');
        } else {
            return redirect()->route('fundraiser.post.message.index')->with('error', 'Update Failed!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FundraiserUpdateMessage  $fundraiserupdatemessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(FundraiserUpdateMessage $fundraiserupdatemessage) {
        if ($fundraiserupdatemessage->user_id != Auth::id()) {
            abort(404);
        }
        $fundraiserupdatemessage->delete();
        return back()->with('success', 'Message Deleted Successfull!');
    }
}