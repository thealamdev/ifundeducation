<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\FundraiserApprovalComments;
use App\Models\FundraiserCategory;
use App\Models\FundraiserPost;
use App\Models\FundraiserPostUpdate;
use App\Notifications\FundraiserStatusUpdateNotify;
use App\Notifications\FundraiserUpdateNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class FundraiserPostController extends Controller {

    public function runningCampaign() {

        $fundposts = FundraiserPost::select('id', 'title')
            ->where('status', 'running')
            ->get();
        $fundpostsCategory = FundraiserCategory::where('status', 1)->get();

        return view('backend.fundraiser_post.index', compact('fundposts', 'fundpostsCategory'));
    }

    public function runningCampaignDatatable(Request $request) {
        $posts = FundraiserPost::with('fundraisercategory')->where('status', 'running');
        if ($request->all()) {
            $posts->where(function ($query) use ($request) {
                if ($request->title) {
                    $query->where('id', '=', $request->title);
                }
                if ($request->category) {
                    $query->where('fundraiser_category_id', '=', $request->category);
                }
                if ($request->fromdate) {
                    $from_date = date("Y-m-d", strtotime($request->fromdate));
                    $query->where('created_at', '>=', $from_date);
                }
                if ($request->todate) {
                    $to_date = date("Y-m-d", strtotime($request->todate));
                    $query->where('end_date', '<=', $to_date);
                }
            });
        }
        return DataTables::of($posts)

            ->addColumn('category', function ($posts) {
                return '<span class="badge bg-success">' . $posts->fundraisercategory->name . '</span>';

            })
            ->editColumn('goal', function ($posts) {
                return '$' . number_format($posts->goal, 2);
            })
            ->editColumn('end_date', function ($posts) {
                return $posts->end_date->format('M d, Y');
            })
            ->editColumn('status', function ($posts) {
                $status = '<span class="badge bg-success">' . Str::ucfirst($posts->status) . '</span>';
                return $status;
            })
            ->editColumn('created_at', function ($posts) {
                return $posts->created_at->format('M d, Y');
            })
            ->addColumn('action_column', function ($posts) {
                $links = '';

                $links .= '<a href="' . route('dashboard.fundraiser.campaign.campaign.show', $posts->slug) . '"
                class="btn btn-sm btn-primary" title="View">
                View
            </a>';

                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function pendingCampaign() {
        $fundposts = FundraiserPost::select('id', 'title')
            ->where('status', 'pending')
            ->get();
        $fundpostsCategory = FundraiserCategory::where('status', 1)->get();
        return view('backend.fundraiser_post.pending', compact('fundposts', 'fundpostsCategory'));
    }

    public function pendingCampaignDatatable(Request $request) {
        $posts = FundraiserPost::with('fundraisercategory')->where('status', 'pending');
        if ($request->all()) {
            $posts->where(function ($query) use ($request) {
                if ($request->title) {
                    $query->where('id', '=', $request->title);
                }
                if ($request->category) {
                    $query->where('fundraiser_category_id', '=', $request->category);
                }
                if ($request->fromdate) {
                    $from_date = date("Y-m-d", strtotime($request->fromdate));
                    $query->where('created_at', '>=', $from_date);
                }
                if ($request->todate) {
                    $to_date = date("Y-m-d", strtotime($request->todate));
                    $query->where('end_date', '<=', $to_date);
                }
            });
        }
        return DataTables::of($posts)

            ->addColumn('category', function ($posts) {
                return '<span class="badge bg-success">' . $posts->fundraisercategory->name . '</span>';

            })
            ->editColumn('goal', function ($posts) {
                return '$' . number_format($posts->goal, 2);
            })
            ->editColumn('end_date', function ($posts) {
                return $posts->end_date->format('M d, Y');
            })
            ->editColumn('status', function ($posts) {
                $status = '<span class="badge bg-warning">' . Str::ucfirst($posts->status) . '</span>';
                return $status;
            })
            ->editColumn('created_at', function ($posts) {
                return $posts->created_at->format('M d, Y');
            })
            ->addColumn('action_column', function ($posts) {
                $links = '';

                $links .= '<a href="' . route('dashboard.fundraiser.campaign.campaign.show', $posts->slug) . '"
                class="btn btn-sm btn-primary" title="View">
                View
            </a>';

                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function completedCampaign() {
        $fundposts = FundraiserPost::select('id', 'title')
            ->where('status', 'completed')
            ->get();
        $fundpostsCategory = FundraiserCategory::where('status', 1)->get();
        return view('backend.fundraiser_post.completed', compact('fundposts', 'fundpostsCategory'));
    }

    public function completedCampaignDatatable(Request $request) {
        $posts = FundraiserPost::with('fundraisercategory')->where('status', 'completed');
        if ($request->all()) {
            $posts->where(function ($query) use ($request) {
                if ($request->title) {
                    $query->where('id', '=', $request->title);
                }
                if ($request->category) {
                    $query->where('fundraiser_category_id', '=', $request->category);
                }
                if ($request->fromdate) {
                    $from_date = date("Y-m-d", strtotime($request->fromdate));
                    $query->where('created_at', '>=', $from_date);
                }
                if ($request->todate) {
                    $to_date = date("Y-m-d", strtotime($request->todate));
                    $query->where('end_date', '<=', $to_date);
                }
            });
        }
        return DataTables::of($posts)

            ->addColumn('category', function ($posts) {
                return '<span class="badge bg-success">' . $posts->fundraisercategory->name . '</span>';

            })
            ->editColumn('goal', function ($posts) {
                return '$' . number_format($posts->goal, 2);
            })
            ->editColumn('end_date', function ($posts) {
                return $posts->end_date->format('M d, Y');
            })
            ->editColumn('status', function ($posts) {
                $status = '<span class="badge bg-success">' . Str::ucfirst($posts->status) . '</span>';
                return $status;
            })
            ->editColumn('created_at', function ($posts) {
                return $posts->created_at->format('M d, Y');
            })
            ->addColumn('action_column', function ($posts) {
                $links = '';

                $links .= '<a href="' . route('dashboard.fundraiser.campaign.campaign.show', $posts->slug) . '"
                class="btn btn-sm btn-primary" title="View">
                View
            </a>';

                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function blockCampaign() {
        $fundposts = FundraiserPost::select('id', 'title')
            ->where('status', 'block')
            ->get();
        $fundpostsCategory = FundraiserCategory::where('status', 1)->get();
        return view('backend.fundraiser_post.block', compact('fundposts', 'fundpostsCategory'));
    }

    public function blockCampaignDatatable(Request $request) {
        $posts = FundraiserPost::with('fundraisercategory')->where('status', 'block');
        if ($request->all()) {
            $posts->where(function ($query) use ($request) {
                if ($request->title) {
                    $query->where('id', '=', $request->title);
                }
                if ($request->category) {
                    $query->where('fundraiser_category_id', '=', $request->category);
                }
                if ($request->fromdate) {
                    $from_date = date("Y-m-d", strtotime($request->fromdate));
                    $query->where('created_at', '>=', $from_date);
                }
                if ($request->todate) {
                    $to_date = date("Y-m-d", strtotime($request->todate));
                    $query->where('end_date', '<=', $to_date);
                }
            });
        }
        return DataTables::of($posts)

            ->addColumn('category', function ($posts) {
                return '<span class="badge bg-success">' . $posts->fundraisercategory->name . '</span>';

            })
            ->editColumn('goal', function ($posts) {
                return '$' . number_format($posts->goal, 2);
            })
            ->editColumn('end_date', function ($posts) {
                return $posts->end_date->format('M d, Y');
            })
            ->editColumn('status', function ($posts) {

                $status = '<span class="badge bg-danger">' . Str::ucfirst($posts->status) . '</span>';
                return $status;
            })
            ->editColumn('created_at', function ($posts) {
                return $posts->created_at->format('M d, Y');
            })
            ->addColumn('action_column', function ($posts) {
                $links = '';

                $links .= '<a href="' . route('dashboard.fundraiser.campaign.campaign.show', $posts->slug) . '"
                class="btn btn-sm btn-primary" title="View">
                View
            </a>';

                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }
    public function stopCampaign() {
        $fundposts = FundraiserPost::select('id', 'title')
            ->where('status', 'stop')
            ->get();
        $fundpostsCategory = FundraiserCategory::where('status', 1)->get();
        return view('backend.fundraiser_post.stop', compact('fundposts', 'fundpostsCategory'));
    }

    public function stopCampaignDatatable(Request $request) {
        $posts = FundraiserPost::with('fundraisercategory')->where('status', 'stop');
        if ($request->all()) {
            $posts->where(function ($query) use ($request) {
                if ($request->title) {
                    $query->where('id', '=', $request->title);
                }
                if ($request->category) {
                    $query->where('fundraiser_category_id', '=', $request->category);
                }
                if ($request->fromdate) {
                    $from_date = date("Y-m-d", strtotime($request->fromdate));
                    $query->where('created_at', '>=', $from_date);
                }
                if ($request->todate) {
                    $to_date = date("Y-m-d", strtotime($request->todate));
                    $query->where('end_date', '<=', $to_date);
                }
            });
        }
        return DataTables::of($posts)

            ->addColumn('category', function ($posts) {
                return '<span class="badge bg-success">' . $posts->fundraisercategory->name . '</span>';

            })
            ->editColumn('goal', function ($posts) {
                return '$' . number_format($posts->goal, 2);
            })
            ->editColumn('end_date', function ($posts) {
                return $posts->end_date->format('M d, Y');
            })
            ->editColumn('status', function ($posts) {
                $status = '<span class="badge bg-danger">' . Str::ucfirst($posts->status) . '</span>';
                return $status;
            })
            ->editColumn('created_at', function ($posts) {
                return $posts->created_at->format('M d, Y');
            })
            ->addColumn('action_column', function ($posts) {
                $links = '';

                $links .= '<a href="' . route('dashboard.fundraiser.campaign.campaign.show', $posts->slug) . '"
                class="btn btn-sm btn-primary" title="View">
                View
            </a>';

                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }
    public function reviewedCampaign() {
        $fundposts = FundraiserPost::select('id', 'title')
            ->where('status', 'reviewed')
            ->get();
        $fundpostsCategory = FundraiserCategory::where('status', 1)->get();
        return view('backend.fundraiser_post.reviewed', compact('fundposts', 'fundpostsCategory'));
    }

    public function reviewedCampaignDatatable(Request $request) {
        $posts = FundraiserPost::with('fundraisercategory')->where('status', 'reviewed');
        if ($request->all()) {
            $posts->where(function ($query) use ($request) {
                if ($request->title) {
                    $query->where('id', '=', $request->title);
                }
                if ($request->category) {
                    $query->where('fundraiser_category_id', '=', $request->category);
                }
                if ($request->fromdate) {
                    $from_date = date("Y-m-d", strtotime($request->fromdate));
                    $query->where('created_at', '>=', $from_date);
                }
                if ($request->todate) {
                    $to_date = date("Y-m-d", strtotime($request->todate));
                    $query->where('end_date', '<=', $to_date);
                }
            });
        }
        return DataTables::of($posts)

            ->addColumn('category', function ($posts) {
                return '<span class="badge bg-success">' . $posts->fundraisercategory->name . '</span>';

            })
            ->editColumn('goal', function ($posts) {
                return '$' . number_format($posts->goal, 2);
            })
            ->editColumn('end_date', function ($posts) {
                return $posts->end_date->format('M d, Y');
            })
            ->editColumn('status', function ($posts) {
                $status = '<span class="badge bg-danger">' . Str::ucfirst($posts->status) . '</span>';
                return $status;
            })
            ->editColumn('created_at', function ($posts) {
                return $posts->created_at->format('M d, Y');
            })
            ->addColumn('action_column', function ($posts) {
                $links = '';

                $links .= '<a href="' . route('dashboard.fundraiser.campaign.campaign.show', $posts->slug) . '"
                class="btn btn-sm btn-primary" title="View">
                View
            </a>';

                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function showCampaign($slug) {
        $fundRaiserPost = FundraiserPost::with([
            'donates',
            'comments' => function ($q) {
                $q->with('replies')->orderBy('created_at', "desc");
            }])->where('slug', $slug)->firstOrfail();

        if ($fundRaiserPost->status === "reviewed") {
            $fundRaiserPost->load('reviewedComments');
        }
        if ($fundRaiserPost->status === "block") {
            $fundRaiserPost->load('blockComments');
        }
        // return $fundRaiserPost;
        return view('backend.fundraiser_post.show', compact('fundRaiserPost'));
    }
    public function statusChangeCampaign(Request $request) {

        $fundraiserpost = FundraiserPost::with('user')->where('id', $request->fundRaiserPost)->first();

        if ($request->status == 'running') {

            $postUpdate = FundraiserPostUpdate::where('fundraiser_post_id', $fundraiserpost->id)
                ->where('status', "running")
                ->first();
            if (!$postUpdate) {
                FundraiserPostUpdate::create([
                    'user_id'                => $fundraiserpost->user_id,
                    'fundraiser_category_id' => $fundraiserpost->fundraiser_category_id,
                    'fundraiser_post_id'     => $fundraiserpost->id,
                    'slug'                   => $fundraiserpost->slug,
                    'title'                  => $fundraiserpost->title,
                    'shot_description'       => $fundraiserpost->shot_description,
                    'goal'                   => $fundraiserpost->goal,
                    'end_date'               => $fundraiserpost->end_date,
                    'image'                  => $fundraiserpost->image,
                    'story'                  => $fundraiserpost->story,
                    'agree'                  => $fundraiserpost->agree,
                    'status'                 => "primary",
                    'accepted_by'            => Auth::id(),
                ]);
            }

            $fundraiserpost->update([
                'status' => 'running',
            ]);
        } else if ($request->status == 'block') {
            $fundraiserpost->update([
                'status' => 'block',
            ]);
        } else if ($request->status == 'reviewed') {
            $fundraiserpost->update([
                'status' => 'reviewed',
            ]);
        }

        if ($request->comment) {
            $updatePostStatus = FundraiserApprovalComments::create([
                "fundraiser_post_id" => $fundraiserpost->id,
                "comments"           => $request->comment,
                "status"             => $request->status,
                "admin_id"           => Auth::id(),
            ]);

            Notification::send($fundraiserpost->user, new FundraiserStatusUpdateNotify($updatePostStatus, $fundraiserpost->title));
        }

        return back()->with('success', 'Successfully Update!');

    }

    // update request

    public function updateCampaign() {
        $fundposts = FundraiserPostUpdate::select('id', 'title')
            ->where('status', 'pending')
            ->get();
        $fundpostsCategory = FundraiserCategory::where('status', 1)->get();
        return view('backend.fundraiser_post.update', compact('fundposts', 'fundpostsCategory'));
    }

    public function updateCampaignDatatable(Request $request) {
        $posts = FundraiserPostUpdate::where('status', 'pending');
        if ($request->all()) {
            $posts->where(function ($query) use ($request) {
                if ($request->title) {
                    $query->where('id', '=', $request->title);
                }
                if ($request->category) {
                    $query->where('fundraiser_category_id', '=', $request->category);
                }
                if ($request->fromdate) {
                    $from_date = date("Y-m-d", strtotime($request->fromdate));
                    $query->where('created_at', '>=', $from_date);
                }
                if ($request->todate) {
                    $to_date = date("Y-m-d", strtotime($request->todate));
                    $query->where('end_date', '<=', $to_date);
                }
            });
        }
        return DataTables::of($posts)

            ->addColumn('category', function ($posts) {
                return '<span class="badge bg-success">' . $posts->fundraisercategory->name . '</span>';

            })
            ->editColumn('goal', function ($posts) {
                return '$' . number_format($posts->goal, 2);
            })
            ->editColumn('end_date', function ($posts) {
                return $posts->end_date->format('M d, Y');
            })
            ->editColumn('status', function ($posts) {
                $statusui = $posts->status == 'updated' ? 'success' : ($posts->status == 'pending' ? 'warning' : 'danger');
                $status   = '<span class="badge bg-' . $statusui . '">' . Str::ucfirst($posts->status) . '</span>';
                return $status;
            })
            ->editColumn('created_at', function ($posts) {
                return $posts->created_at->format('M d, Y');
            })
            ->addColumn('action_column', function ($posts) {
                $links = '';

                $links .= '<a href="' . route('dashboard.fundraiser.campaign.campaign.update.request.show', $posts->slug) . '"
                class="btn btn-sm btn-primary" title="View">
                View
            </a>';

                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function updateCampaignShow($slug) {
        $updatePost  = FundraiserPostUpdate::where('slug', $slug)->orderBy('id', 'desc')->firstOrfail();
        $currentPost = FundraiserPost::where('id', $updatePost->fundraiser_post_id)->firstOrfail();

        if ($updatePost->status != 'pending') {
            abort(404);
        }

        $updateCategories = FundraiserCategory::where('id', 'fundraiser_category_id')->get();

        return view('backend.fundraiser_post.updateshow', compact('updatePost', 'updateCategories', 'currentPost'));
    }
    public function fundraiserRequestUpdate(Request $request) {

        $updatePost  = FundraiserPostUpdate::where('id', $request->update_post_id)->firstOrfail();
        $currentPost = FundraiserPost::with('user')->where('id', $updatePost->fundraiser_post_id)->firstOrfail();

        if ($request->status == 'cancelled') {
            $notifyComment = $updatePost->update([
                'status'         => 'cancelled',
                "admin_comments" => $request->comment,
                "cancel_by"      => Auth::id(),
            ]);

            Notification::send($currentPost->user, new FundraiserUpdateNotify($updatePost));

        } else if ($request->status == 'updated') {

            if (file_exists(public_path('storage/fundraiser_post/' . $currentPost->image))) {
                Storage::delete('fundraiser_post/' . $currentPost->image);
            }

            $currentPost->update([
                'fundraiser_category_id' => $updatePost->fundraiser_category_id,
                'title'                  => $updatePost->title,
                'shot_description'       => $updatePost->shot_description,
                'goal'                   => $updatePost->goal,
                'end_date'               => $updatePost->end_date,
                'image'                  => $updatePost->image,
                'story'                  => $updatePost->story,
            ]);
            $updatePost->update([
                'status'         => 'updated',
                "admin_comments" => $request->comment,
                "accepted_by"    => Auth::id(),
            ]);
            Notification::send($currentPost->user, new FundraiserUpdateNotify($updatePost));
        }

        return redirect()->route('dashboard.fundraiser.campaign.campaign.all')->with('success', 'Successfully Update!');

    }
}