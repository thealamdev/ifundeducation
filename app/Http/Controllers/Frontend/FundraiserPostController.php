<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Donate;
use App\Models\FundraiserApprovalComments;
use App\Models\FundraiserCategory;
use App\Models\FundraiserPost;
use App\Models\FundraiserPostUpdate;
use App\Models\FundraiserUpdateMessage;
use App\Models\ThemeOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use PDF;
use Yajra\DataTables\Facades\DataTables;

class FundraiserPostController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $fundposts = FundraiserPost::select('id', 'title')
            ->where('user_id', Auth::id())
            ->where('status', 'running')
            ->get();
        $fundpostsCategory = FundraiserCategory::where('status', 1)->get();

        return view('frontend.fundraiser_post.index', compact('fundposts', 'fundpostsCategory'));
    }

    public function postDataTable(Request $request) {
        $posts = FundraiserPost::with('fundraisercategory')
            ->where('user_id', auth()->user()->id)
            ->where('status', 'running');

        if ($request->all()) {
            $posts->where(function ($query) use ($request) {
                if ($request->title) {
                    $query->where('id', '=', $request->title);
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

                if ($posts->status == 'stop') {
                    $links = '<a href="' . route('fundraiser.post.running', $posts->slug) . '" title="Restart"
                    class="action_icon running_campaign">
                    <i class="fa-regular fa-circle-play"></i></a>';
                } else {
                    $links = '<a href="' . route('fundraiser.post.stop', $posts->slug) . '" title="Stop"
                    class="action_icon stop_campaign"> <i class="fa-regular fa-circle-stop"></i></a>';
                }

                $links .= '<a href="' . route('fundraiser.post.show', $posts->slug) . '" class="action_icon"
                title="View">
                <i class="fas fa-eye"></i></a><a href="' . route('fundraiser.post.edit', $posts->slug) . '" class="action_icon"
                title="Edit"> <i class="fas fa-edit"></i></a>
                <form action="' . route('fundraiser.post.delete', $posts->slug) . '" method="POST"
                class="d-inline" style="cursor: pointer">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <p class="action_icon delete post_delete" title="Delete">
                        <i class="fas fa-trash"></i>
                    </p>
                </form>';

                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function pendingCampaign() {

        $fundposts = FundraiserPost::select('id', 'title')
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->get();
        $fundpostsCategory = FundraiserCategory::where('status', 1)->get();

        return view('frontend.fundraiser_post.pending', compact('fundposts', 'fundpostsCategory'));
    }
    public function pendingCampaignDatatable(Request $request) {
        $posts = FundraiserPost::with('fundraisercategory')
            ->where('user_id', auth()->user()->id)
            ->where('status', 'pending');

        if ($request->all()) {
            $posts->where(function ($query) use ($request) {
                if ($request->title) {
                    $query->where('id', '=', $request->title);
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

                $links .= '<a href="' . route('fundraiser.post.show', $posts->slug) . '" class="action_icon"
                title="View">
                <i class="fas fa-eye"></i></a><a href="' . route('fundraiser.post.edit', $posts->slug) . '" class="action_icon"
                title="Edit"> <i class="fas fa-edit"></i></a>
                <form action="' . route('fundraiser.post.delete', $posts->slug) . '" method="POST"
                class="d-inline" style="cursor: pointer">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <p class="action_icon delete post_delete" title="Delete">
                        <i class="fas fa-trash"></i>
                    </p>
                </form>';

                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function completedCampaign() {

        $fundposts = FundraiserPost::select('id', 'title')
            ->where('user_id', Auth::id())
            ->where('status', 'completed')
            ->get();
        $fundpostsCategory = FundraiserCategory::where('status', 1)->get();

        return view('frontend.fundraiser_post.completed', compact('fundposts', 'fundpostsCategory'));
    }

    public function completedCampaignDatatable(Request $request) {
        $posts = FundraiserPost::with('fundraisercategory')
            ->where('user_id', auth()->user()->id)
            ->where('status', 'completed');

        if ($request->all()) {
            $posts->where(function ($query) use ($request) {
                if ($request->title) {
                    $query->where('id', '=', $request->title);
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

                $links .= '<a href="' . route('fundraiser.post.show', $posts->slug) . '" class="action_icon"
                title="View">
                <i class="fas fa-eye"></i></a>
                <form action="' . route('fundraiser.post.delete', $posts->slug) . '" method="POST"
                class="d-inline" style="cursor: pointer">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <p class="action_icon delete post_delete" title="Delete">
                        <i class="fas fa-trash"></i>
                    </p>
                </form>';

                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function blockCampaign() {

        $fundposts = FundraiserPost::select('id', 'title')
            ->where('user_id', Auth::id())
            ->where('status', 'block')
            ->get();
        $fundpostsCategory = FundraiserCategory::where('status', 1)->get();

        return view('frontend.fundraiser_post.block', compact('fundposts', 'fundpostsCategory'));
    }
    public function blockCampaignDatatable(Request $request) {
        $posts = FundraiserPost::with('fundraisercategory')
            ->where('user_id', auth()->user()->id)
            ->where('status', 'block');

        if ($request->all()) {
            $posts->where(function ($query) use ($request) {
                if ($request->title) {
                    $query->where('id', '=', $request->title);
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

                $links .= '<a href="' . route('fundraiser.post.show', $posts->slug) . '" class="action_icon"
                title="View">
                <i class="fas fa-eye"></i></a>
                <form action="' . route('fundraiser.post.delete', $posts->slug) . '" method="POST"
                class="d-inline" style="cursor: pointer">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <p class="action_icon delete post_delete" title="Delete">
                        <i class="fas fa-trash"></i>
                    </p>
                </form>';

                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function stopCampaign() {

        $fundposts = FundraiserPost::select('id', 'title')
            ->where('user_id', Auth::id())
            ->where('status', 'stop')
            ->get();
        $fundpostsCategory = FundraiserCategory::where('status', 1)->get();

        return view('frontend.fundraiser_post.stop', compact('fundposts', 'fundpostsCategory'));
    }
    public function stopCampaignDatatable(Request $request) {
        $posts = FundraiserPost::with('fundraisercategory')
            ->where('user_id', auth()->user()->id)
            ->where('status', 'stop');

        if ($request->all()) {
            $posts->where(function ($query) use ($request) {
                if ($request->title) {
                    $query->where('id', '=', $request->title);
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

                $links .= '<a href="' . route('fundraiser.post.running', $posts->slug) . '" title="Restart"
                    class="action_icon running_campaign">
                    <i class="fa-regular fa-circle-play"></i></a>';

                $links .= '<a href="' . route('fundraiser.post.show', $posts->slug) . '" class="action_icon"
                title="View">
                <i class="fas fa-eye"></i></a>
                <form action="' . route('fundraiser.post.delete', $posts->slug) . '" method="POST"
                class="d-inline" style="cursor: pointer">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <p class="action_icon delete post_delete" title="Delete">
                        <i class="fas fa-trash"></i>
                    </p>
                </form>';

                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function reviewedCampaign() {

        $fundposts = FundraiserPost::select('id', 'title')
            ->where('user_id', Auth::id())
            ->where('status', 'reviewed')
            ->get();
        $fundpostsCategory = FundraiserCategory::where('status', 1)->get();

        return view('frontend.fundraiser_post.reviewed', compact('fundposts', 'fundpostsCategory'));
    }
    public function reviewedCampaignDatatable(Request $request) {
        $posts = FundraiserPost::with('fundraisercategory')
            ->where('user_id', auth()->user()->id)
            ->where('status', 'reviewed');

        if ($request->all()) {
            $posts->where(function ($query) use ($request) {
                if ($request->title) {
                    $query->where('id', '=', $request->title);
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

                $links .= '<a href="' . route('fundraiser.post.show', $posts->slug) . '" class="action_icon"
                title="View">
                <i class="fas fa-eye"></i></a><a href="' . route('fundraiser.post.edit', $posts->slug) . '" class="action_icon"
                title="Edit"> <i class="fas fa-edit"></i></a>
                <form action="' . route('fundraiser.post.delete', $posts->slug) . '" method="POST"
                class="d-inline" style="cursor: pointer">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <p class="action_icon delete post_delete" title="Delete">
                        <i class="fas fa-trash"></i>
                    </p>
                </form>';

                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function draftCampaign() {

        $fundposts = FundraiserPost::select('id', 'title')
            ->where('user_id', Auth::id())
            ->where('status', 'draft')
            ->get();
        $fundpostsCategory = FundraiserCategory::where('status', 1)->get();

        return view('frontend.fundraiser_post.draft', compact('fundposts', 'fundpostsCategory'));
    }
    public function draftCampaignDatatable(Request $request) {
        $posts = FundraiserPost::with('fundraisercategory')
            ->where('user_id', auth()->user()->id)
            ->where('status', 'draft');

        if ($request->all()) {
            $posts->where(function ($query) use ($request) {
                if ($request->title) {
                    $query->where('id', '=', $request->title);
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

                $links .= '<a href="' . route('fundraiser.post.show', $posts->slug) . '" class="action_icon"
                title="View">
                <i class="fas fa-eye"></i></a><a href="' . route('fundraiser.post.edit', $posts->slug) . '" class="action_icon"
                title="Edit"> <i class="fas fa-edit"></i></a>
                <form action="' . route('fundraiser.post.delete', $posts->slug) . '" method="POST"
                class="d-inline" style="cursor: pointer">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <p class="action_icon delete post_delete" title="Delete">
                        <i class="fas fa-trash"></i>
                    </p>
                </form>';

                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    // download
    public function downloadCampaignList(Request $request) {
        // return $request;
        $themeOption = ThemeOption::first();

        $posts = FundraiserPost::withSum('donates', 'net_balance')->where('user_id', Auth::id());

        if ($request->all()) {
            $posts->where(function ($query) use ($request) {
                if ($request->pdf_title) {
                    $query->where('id', '=', $request->pdf_title);
                }
                if ($request->status) {
                    $query->where('status', '=', $request->status);
                }
                if ($request->start_date) {
                    $from_date = date("Y-m-d", strtotime($request->start_date));
                    $query->where('created_at', '>=', $from_date);
                }
                if ($request->to_date) {
                    $to_date = date("Y-m-d", strtotime($request->to_date));
                    $query->where('end_date', '<=', $to_date);
                }
            });
        }

        $campaigns = $posts->get();
        // return $campaigns;
        if ($campaigns->isEmpty()) {
            return back()->with('warning', 'Campaign not found!');
        }

        $table_columns = [];
        if ($request->campaign_id_column) {
            array_push($table_columns, 'campaign_id_column');
        }
        if ($request->campaign_title_column) {
            array_push($table_columns, 'campaign_title_column');
        }
        if ($request->start_date_column) {
            array_push($table_columns, 'start_date_column');
        }
        if ($request->end_date_column) {
            array_push($table_columns, 'end_date_column');
        }
        if ($request->target_column) {
            array_push($table_columns, 'target_column');
        }
        if ($request->raised_column) {
            array_push($table_columns, 'raised_column');
        }
        if ($request->status_column) {
            array_push($table_columns, 'status_column');
        }
        // return $table_columns;

        $data = [
            'campaigns'    => $campaigns,
            'themeOption'  => $themeOption,
            'table_column' => $table_columns,
        ];
        $pdf = PDF::loadView('pdf.frontend.campaignpdf', $data);
        $pdf->download('campaign.pdf');
        return back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if (empty(auth()->user()->personal_profile) || empty(auth()->user()->academic_profile)) {
            return redirect()->route('user.profile.edit');
        }
        $categories = FundraiserCategory::orderBy('id', 'desc')->where('status', true)->get();
        return view('frontend.fundraiser_post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $image = $request->file('image');
        $request->validate([
            'title'            => 'required|max:100',
            'shot_description' => 'required|max:250',
            'goal'             => 'required|integer',
            'end_date'         => 'required|date',
            'image'            => 'nullable|mimes:png,jpg, webp|max:300',
            'category'         => 'required',
            'story'            => 'nullable|max:1500',
            'agree'            => 'required',
        ]);
        if ($image) {

            $image_name = Str::ulid() . '.' . $image->extension();

            $upload = Image::make($image)->resize(250, 250)->save(public_path('storage/fundraiser_post/' . $image_name));
        } else {
            $image_name = null;
        }
        $post = FundraiserPost::create([
            'user_id'                => auth()->user()->id,
            'fundraiser_category_id' => $request->category,
            'title'                  => $request->title,
            'slug'                   => Str::slug($request->title) . '-' . Str::lower(Str::ulid()) . time(),
            'shot_description'       => $request->shot_description,
            'goal'                   => $request->goal,
            'end_date'               => $request->end_date,
            'image'                  => $image_name,
            'story'                  => $request->story,
            'agree'                  => $request->agree === 'on' ? true : false,
            'status'                 => $request->save_draft === "draft" ? "draft" : "pending",
        ]);

        if ($request->save_draft === "draft") {
            return redirect()->route('fundraiser.post.index')->with('success', 'Fundraiser Post Save to draft!');
        } else {
            return redirect()->route('fundraiser.post.index')->with('success', 'Fundraiser Post Published!');
        }
    }

    //ck editor image upload
    public function storyPhoto(Request $request) {
        if ($request->hasFile('upload')) {
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName  = Str::ulid() . '.' . $extension;

            $request->file('upload')->storeAs('fundraiser_post', $fileName);

            $url = asset('storage/fundraiser_post/' . $fileName);

            return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FundraiserPost  $fundraiserPost
     * @return \Illuminate\Http\Response
     */
    public function show($slug) {
        $lastApprovedComment = [];
        $fundraiserpost      = FundraiserPost::where('slug', $slug)->where('user_id', Auth::id())->firstOrFail();

        if ($fundraiserpost->user_id != Auth::id()) {
            abort(404);
        }

        if ($fundraiserpost->status == 'reviewed') {

            $lastApprovedComment = FundraiserApprovalComments::where('fundraiser_post_id', $fundraiserpost->id)
                ->where('status', 'reviewed')
                ->orderBy('id', 'desc')
                ->get();
        }
        if ($fundraiserpost->status == 'block') {

            $lastApprovedComment = FundraiserApprovalComments::where('fundraiser_post_id', $fundraiserpost->id)
                ->where('status', 'block')
                ->orderBy('id', 'desc')
                ->get();
        }

        // return $lastApprovedComment;

        return view('frontend.fundraiser_post.show_dashboard', compact('fundraiserpost', 'lastApprovedComment'));
    }

    public function singleDonationDataTable(FundraiserPost $fundraiserpost) {

        $singleDonates = Donate::where('fundraiser_post_id', $fundraiserpost->id);

        return DataTables::of($singleDonates)

            ->editColumn('net_balance', function ($singleDonates) {
                return '$' . number_format($singleDonates->net_balance, 2);
            })
            ->editColumn('created_at', function ($singleDonates) {
                return $singleDonates->created_at->format('M d, Y');
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }
    public function singleCommentsDataTable(FundraiserPost $fundraiserpost) {

        $singleComments = Comment::where('fundraiser_post_id', $fundraiserpost->id);

        return DataTables::of($singleComments)

            ->editColumn('status', function ($singleComments) {
                $statusbg = $singleComments->status == 'approved' ? 'success' : 'warning';
                return '<span class="badge bg-' . $statusbg . '">' . $singleComments->status . '</span>';
            })
            ->editColumn('created_at', function ($singleComments) {
                return $singleComments->created_at->format('M d, Y');
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }
    public function singleUpdatemessageDataTable(FundraiserPost $fundraiserpost) {

        $singleUpdateMessage = FundraiserUpdateMessage::where('fundraiser_post_id', $fundraiserpost->id);

        return DataTables::of($singleUpdateMessage)
            ->editColumn('created_at', function ($singleUpdateMessage) {
                return $singleUpdateMessage->created_at->format('M d, Y');
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FundraiserPost  $fundraiserPost
     * @return \Illuminate\Http\Response
     */
    public function edit($slug) {
        $fundraiserpost = FundraiserPost::with('pendingUpdate')
            ->where('slug', $slug)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($fundraiserpost->user_id != Auth::id()) {
            abort(404);
        }

        $categories = FundraiserCategory::orderBy('id', 'desc')->where('status', true)->get();

        // return $fundraiserpost;

        return view('frontend.fundraiser_post.edit', compact('categories', 'fundraiserpost'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FundraiserPost  $fundraiserPost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug) {
        $fundraiserpost = FundraiserPost::where('slug', $slug)->where('user_id', Auth::id())->firstOrFail();
        if ($fundraiserpost->user_id != Auth::id()) {
            abort(404);
        }
        $image = $request->file('image');
        $request->validate([
            'title'            => 'required|max:100',
            'shot_description' => 'required|max:250',
            'goal'             => 'required|integer',
            'end_date'         => 'required|date',
            'image'            => 'nullable|mimes:png,jpg, webp|max:300',
            'category'         => 'required',
            'story'            => 'nullable|max:1500',
        ]);

        // return $fundraiserpost;

        if ($fundraiserpost->status === "running") {

            if ($image) {

                $image_name = Str::ulid() . '.' . $image->extension();

                $upload = Image::make($image)->resize(250, 250)->save(public_path('storage/fundraiser_post/' . $image_name));
            } else {
                $image_name = $fundraiserpost->image;
            }

            FundraiserPostUpdate::create([
                'user_id'                => auth()->user()->id,
                'fundraiser_post_id'     => $fundraiserpost->id,
                'slug'                   => $fundraiserpost->slug,
                'fundraiser_category_id' => $request->category,
                'title'                  => $request->title,
                'shot_description'       => $request->shot_description,
                'goal'                   => $request->goal,
                'end_date'               => $request->end_date,
                'image'                  => $image_name,
                'story'                  => $request->story,
                'agree'                  => $fundraiserpost->agree,
                'status'                 => "pending",
            ]);

            return redirect()->route('fundraiser.post.index')->with('success', 'Updated pending!');

        } else {

            if ($image) {

                if (file_exists(public_path('storage/fundraiser_post/' . $fundraiserpost->image))) {
                    Storage::delete('fundraiser_post/' . $fundraiserpost->image);
                }

                $image_name = Str::ulid() . '.' . $image->extension();

                $upload = Image::make($image)->resize(250, 250)->save(public_path('storage/fundraiser_post/' . $image_name));
            } else {
                $image_name = $fundraiserpost->image;
            }

            $fundraiserpost->update([
                'fundraiser_category_id' => $request->category,
                'title'                  => $request->title,
                'shot_description'       => $request->shot_description,
                'goal'                   => $request->goal,
                'end_date'               => $request->end_date,
                'image'                  => $image_name,
                'story'                  => $request->story,
            ]);

            if ($request->save_draft === "draft") {
                $fundraiserpost->update([
                    'status' => "draft",
                ]);
                return redirect()->route('fundraiser.post.campaign.draft')->with('success', 'Fundraiser Save to draft!');

            } else {
                $fundraiserpost->update([
                    'status' => "pending",
                ]);

                return redirect()->route('fundraiser.post.campaign.pending')->with('success', 'Fundraiser Post published!');
            }

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FundraiserPost  $fundraiserPost
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug) {
        $fundraiserpost = FundraiserPost::where('slug', $slug)->where('user_id', Auth::id())->firstOrFail();
        if ($fundraiserpost->user_id != Auth::id()) {
            abort(404);
        }
        $fundraiserpost->delete();

        return redirect()->route('fundraiser.post.index')->with('success', 'Fundraiser Post successfully Deleted!');
    }

    public function fundraiserPostShow($slug) {

        $fundRaiserPost = FundraiserPost::with([
            'fundraisercategory',
            'donates'                 => function ($q) {
                $q->select('id', 'donar_name', 'net_balance', 'created_at', 'fundraiser_post_id', 'display_publicly');
            },
            'comments'                => function ($q) {
                $q->with('replies')->where('status', 'approved')->orderBy('created_at', "desc");
            },
            'fundraiserupdatemessage' => function ($q) {
                $q->where('status', 1)->orderBy('created_at', 'desc');
            }])->where('slug', $slug)->where('status', 'running')->firstOrfail();
        $total_comment = Comment::where('fundraiser_post_id', $fundRaiserPost->id)->where('status', 'approved')->count();

        return view('frontend.fundraiser_post.show', compact('fundRaiserPost', 'total_comment'));
    }

    public function stopRunning($slug) {
        $fundraiserpost = FundraiserPost::where('slug', $slug)->where('user_id', Auth::id())->firstOrFail();
        if ($fundraiserpost->user_id != Auth::id()) {
            abort(404);
        }
        if ($fundraiserpost->status == 'pending') {

            return back()->with('warning', 'Campaign is pending!');

        } elseif ($fundraiserpost->status == 'stop') {
            $fundraiserpost->update([
                'status' => 'running',
            ]);
            return back()->with('success', 'Campaign Running Successfull!');
        } else {
            $fundraiserpost->update([
                'status' => 'stop',
            ]);
            return back()->with('success', 'Campaign Stop Successfull!');
        }
    }

}