<?php

namespace App\Http\Controllers;

use App\Models\{Client, Country, Project, Supplier, Respondent, ProjectLink, ProjectStatus, CloseRespondent, SupplierProject, City, FinalId, State, ProjectActivity};
use App\Http\Resources\{ActivityProjectResource, CityResource, CountryResource, ProjectResource, ClientListResource, ProjectLinkResource, ProjectListResource, SupplierListResource, ProjectStatusResource, StateResource, SupplierProjectResource};
use App\Events\{NotificationEvent, SendMessage,};
use App\Exports\{ExportFinalIDs, ProjectReport, ExportIdExport};
use Inertia\Inertia;
use App\Imports\IdImport;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Notifications\ActionNotification;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public $clients, $countries, $suppliers, $status, $company, $user;

    public function __construct()
    {
        $this->clients = ClientListResource::collection(Client::where(['status' => 1])->get());
        $this->countries = CountryResource::collection(Country::orderBy('name', 'asc')->get());
        $this->suppliers = SupplierListResource::collection(Supplier::orderBy('supplier_name', 'asc')->get());
        $this->status = ProjectStatus::orderBy('id', 'asc')->get();
    }

    public function project($id)
    {
        $project = Project::find($id);

        return $project;
    }
    public function user_details()
    {
        return  auth()->user()->first_name . " " . auth()->user()->last_name;
    }
    public function index(Request $request)
    {
            $projects = Project::orderBy('updated_at', 'desc');
            if (Auth::user()->role->role->slug == 'user') {
                $projects = $projects->where(['status' => 'live']);
            }
            if (!empty($request->q)) {
                $projects = $projects->where('project_name', 'like', "%{$request->q}%")->orWhere('project_id', 'like', "%{$request->q}%");
            }
      		if(!$request->status){
              	$projects = $projects->whereNotIn('status',['close']);
             }
            if (!empty($request->status)) {
              
              $projects = $projects->where('status', $request->status);
            }
            if (!empty($request->client)) {
                $projects = $projects->where('client_id', $request->client);
            }
        $projects = $projects->paginate(20)->appends(request()->query());

        return Inertia::render('Project/Index', [
            'projects' => ProjectListResource::collection($projects),
            'status' => ProjectStatusResource::collection($this->status),
            'clients' => $this->clients,
        ]);
    }
    public function create()
    {
        $this->clients = ClientListResource::collection(Client::where(['status' => 1])->get());
        $this->status = ProjectStatus::orderBy('id', 'asc')->get();
        $this->countries = CountryResource::collection(Country::orderBy('name', 'asc')->get());
        return Inertia::render('Project/Create', [
            'clients' => ClientListResource::collection($this->clients),
            'countries' => CountryResource::collection($this->countries),
            'status' => ProjectStatusResource::collection($this->status)
        ]);
        return redirect('/');
    }

    public function getState(Request $request)
    {
        $states = State::where('country_id', $request->country_id)->get();
        $cities = City::where('country_id', $request->country_id)->get();

        return response()->json([
            'states' => StateResource::collection($states),
            'cities' => CityResource::collection($cities),
            'success' => true,
        ]);
    }

    public function getCity(Request $request)
    {
        $cities = City::where('state_id', $request->state_id)->get();
        return response()->json([
            'cities' => CityResource::collection($cities),
            'success' => true,
        ]);
    }

    public function store(Request $request)
    {
        $id = IdGenerator::generate(['table' => 'projects', 'field' => 'project_id', 'length' => 10, 'prefix' => 'ARS' . date('ym')]);
        $zipcode = preg_replace('/\s+/', ' , ',  $request->project_zipcode);

        $stringToCheck = $request->input('project_link'); // Replace 'your_string_key' with the actual key in your request
        $containsRespondentID = Str::contains($stringToCheck, 'RespondentID');

        $request->validate([
            'project_name' => 'required|unique:projects,project_name',
            'client' => 'required',
            'project_cpi' => 'required',
            'project_length' => 'required|numeric',
            'project_ir' => 'required|numeric',
            'start_date' => 'required',
            'end_date' => 'required',
            'project_status' => 'required',
            'project_link' => 'required|url',
            'project_country' => 'required',
            'device_type' => 'required',
            'project_type' => 'required',
            'sample_size' => 'required',
        ]);
        if (!Client::where(['id' => $request->client])->get() && !Country::find($request->project_country)) {
            return redirect()->back()->withErrors(errorMessage());
        }
        if ($containsRespondentID) {
            if ($project = Project::create([
                'project_id' => $id,
                'project_name' => $request->project_name,
                'client_id' => $request->client,
                'user_id' => Auth::user()->id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'device_type' => json_encode($request->device_type),
                'project_type' => $request->project_type,
                'target' => $request->target,
                'status' => $request->project_status,
            ])) {
                if (ProjectLink::create([
                    'project_id' => $project->id,
                    'user_id' => Auth::user()->id,
                    'cpi' => $request->project_cpi,
                    'project_name' => $request->project_name,
                    'loi' => $request->project_length,
                    'ir' => $request->project_ir,
                    'project_link' => $request->project_link,
                    'sample_size' => $request->sample_size,
                    'notes' => $request->notes,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'country_id' => $request->project_country,
                    'state' => implode(' , ', $request->project_state),
                    'city' => implode(' , ', $request->project_city),
                    'zipcode' => $zipcode,
                    'status' => 1,
                ])) {
                    $activity = ProjectActivity::create([
                        "project_id" => $project->project_id,
                        "type_id" => "status",
                        "text" => $request->project_name . ' was created',
                        "user_id"   => Auth::user()->id,

                    ]);
                    broadcast(new SendMessage($project));
                    broadcast(new NotificationEvent([
                        'user_id' => auth()->user()->id,
                        'message' => 'Project - ' . $project->project_name . ' with id - ' . $project->project_id . ' was created by ' . $this->user_details() . '.',
                        'type' => 'notification',
                        'title' => 'Project - ' . $project->project_id
                    ]));
                    auth()->user()->notify(new ActionNotification($project, auth()->user(), $request->project_name . ' was created'));

                    if (!empty($request->add_more)) {
                        return redirect("/project/create")->with('flash', createMessage('Project'));
                    }
                    return redirect("/project/$project->id")->with('flash', createMessage('Project'));
                }
                return redirect()->back()->withErrors(errorMessage());
            }
            return redirect()->back()->withErrors(errorMessage());
        }
        return redirect()->back()->withErrors(['success' => false, 'message' => 'Project link should be RespondentID']);
    }

    public function projectClone(Request $request)
    {
        function randumNumber($inputString)
        {
            $autoNumber =  time();
            $number = $autoNumber % 10;
            $pattern = '/^(.+) clone-(\d+)$/';
            if (preg_match($pattern, $inputString, $matches)) {
                return [
                    "project_name" => $matches[1],
                    "number" => $number
                ];
            } else {
                return [
                    "project_name" => $inputString,
                    "number" => $number
                ];
            }
        }
        $project = Project::where('id', $request->id)->first();
        $projectLinks = ProjectLink::where('project_id', $project->id)->get();
        $id = IdGenerator::generate(['table' => 'projects', 'field' => 'project_id', 'length' => 10, 'prefix' => 'ARS' . date('ym')]);
        $autoNumber =  time();
        $clone = $autoNumber % 10;
        if ($project) {
            if ($project = Project::create([
                'project_id' => $id,
                // 'project_name' => $project->project_name . ' Clone -' . $clone,
                'project_name' => randumNumber($project->project_name)["project_name"] . " clone-" . (randumNumber($project->project_name)["number"] + 1),

                'client_id' => $project->client_id,
                'user_id' => Auth::user()->id,
                'start_date' => $project->start_date,
                'end_date' => $project->end_date,
                'device_type' => $project->device_type,
                'project_type' => $project->project_type,
                'target' => $project->target,
                'status' => $project->status,
            ])) {
                foreach ($projectLinks as $projectlink) {
                    ProjectLink::create([
                        'project_id' => $project->id,
                        'user_id' => Auth::user()->id,
                        'cpi' => $projectlink->cpi,
                        'project_name' => $projectlink->project_name,
                        'loi' => $projectlink->loi,
                        'ir' => $projectlink->ir,
                        'project_link' => $projectlink->project_link,
                        'sample_size' => $projectlink->sample_size,
                        'notes' => $projectlink->notes,
                        'start_date' => $projectlink->start_date,
                        'end_date' => $projectlink->end_date,
                        'country_id' => $projectlink->country_id,
                        'status' => $projectlink->status,
                    ]);
                }
            }
            $activity = ProjectActivity::create([
                "project_id" => $project->project_id,
                "type_id" => "status",
                "text" => $request->project_name . ' was clone',
                "user_id"   => Auth::user()->id,
            ]);
            broadcast(new SendMessage($project));
            broadcast(new NotificationEvent([
                'user_id' => auth()->user()->id,
                'message' => 'Project - ' . $project->project_name . ' with id - ' . $project->project_id . ' was clone by ' . $this->user_details() . '.',
                'type' => 'notification',
                'title' => 'Project - ' . $project->project_id
            ]));
            auth()->user()->notify(new ActionNotification($project, auth()->user(), $request->project_name . ' was clone'));
            return response()->json(createMessage('Project Clone'));
        }
        return redirect()->back()->withErrors(errorMessage());
    }
    public function show(Request $request, $id)
    {
        $project = Project::find($id);
        $links = ProjectLink::where('project_id', $id);
        if (!empty($request->q)) {
            $links = $links->where('project_name', 'like', "%{$request->q}%");
        }
        if ($request->status !== 'all' && $request->status !== null) {
            $links = $links->where('status', (int)$request->status);
        }

        if (!empty($project)) {
            return Inertia::render('Project/Show', [
                'project' => new ProjectResource($project),
                'project_links' => ProjectLinkResource::collection($links->get()),
                'clients' => $this->clients,
                'status' => $this->status,
                'countries' => $this->countries
            ]);
        }
        return redirect(route('projects'));
    }
    public function edit($id)
    {
        $project = Project::find($id);

        return Inertia::render('Project/Edit', [
            'project' => new ProjectResource($project),
            'clients' => $this->clients,
            'countries' => CountryResource::collection($this->countries),
            'status' => ProjectStatusResource::collection($this->status)
        ]);
    }
    public function update(Request $request, $id)
    {

        $request->validate([
            'project_name' => 'required',
            'client' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'project_status' => 'required',
            'device_type' => 'required',
            'project_type' => 'required',
        ]);
        $project = Project::find($id);

        if ($project) {
            if (Project::where('id', $id)->update([
                'project_name' => $request->project_name,
                'client_id' => $request->client,
                'target' => $request->target,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'device_type' => json_encode($request->device_type),
                'project_type' => $request->project_type,
                'target' => $request->target,
                'status' => $request->project_status,
            ])) {
                $activity = ProjectActivity::create([
                    "project_id" => $id,
                    "type_id" => "status",
                    "text" => $request->project_name . " was updated",
                    "user_id"   => Auth::user()->id,

                ]);
                broadcast(new SendMessage($this->project($id)));
                broadcast(new NotificationEvent([
                    'user_id' => auth()->user()->id,
                    'message' => 'Project - ' . $this->project($id)->project_name . ' with id - ' . $this->project($id)->project_id . ' was updated by ' . $this->user_details() . '.',
                    'type' => 'notification',
                    'title' => 'Project - ' . $this->project($id)->project_id
                ]));
                auth()->user()->notify(new ActionNotification($project, auth()->user(), $request->project_name . ' was updated'));
                if ($request->action == 'project_show') {
                    return redirect('project/' . $id)->with('flash', updateMessage('Project'));
                }
                return redirect('projects')->with('flash', updateMessage('Project'));
            }
            return redirect()->back()->withErrors(errorMessage());
        }
        return redirect()->back()->with('flash', errorMessage());
    }
    public function destroy($id)
    {
        $project = Project::where('id', $id)->first();
        if (Project::where('id', $id)->delete()) {
            $activity = ProjectActivity::create([
                "project_id" => $project->project_id,
                "type_id" => "status",
                "text" => $project->project_name . ' was deleted',
                "user_id"   => Auth::user()->id,
            ]);
            broadcast(new SendMessage($this->project($id)));

            broadcast(new NotificationEvent([
                'user_id' => auth()->user()->id,
                'message' => 'Project - ' . $this->project($id)?->project_name . ' with id - ' . $this->project($id)?->project_id . ' was deleted by ' . $this->user_details() . '.',
                'type' => 'notification',
                'title' => 'Project - ' . $this->project($id)?->project_id
            ]));
            auth()->user()->notify(new ActionNotification($project,  Auth::user(), $project?->project_name . ' was deleted'));

            ProjectLink::where('project_id', $id)->delete();
            return response()->json(deleteMessage('Project'));
        }
        return response()->json(errorMessage());
    }

    public function status(Request $request)
    {
        $notification = $this->project($request->id)->project_name . " has been " . $request->status;
        if ($request->status == 'close') {
            $respondents = Respondent::where('project_id', '=', $request->id)->get();
            if (count($respondents) > 0) {
                foreach ($respondents as $respondent) {
                    $create =  CloseRespondent::create([
                        'client_browser' => $respondent->client_browser,
                        'device' => $respondent->device,
                        'end_ip' => $respondent->end_ip,
                        'id' => $respondent->id,
                        'project_id' => $respondent->project_id,
                        'project_link_id' => $respondent->project_link_id,
                        'starting_ip' => $respondent->starting_ip,
                        'status' => $respondent->status,
                        'supplier_id' => $respondent->supplier_id,
                        'supplier_project_id' => $respondent->supplier_project_id,
                        'user_id' => $respondent->user_id,
                    ]);
                }
                $respondents = Respondent::where('project_id', '=', $request->id)->delete();
            }
            $activity = ProjectActivity::create([
                "project_id" => $request->id,
                "type_id" => "status",
                "text" => $notification,
                "user_id"   => Auth::user()->id,

            ]);
            broadcast(new SendMessage($this->project($request->id)));
            broadcast(new NotificationEvent([
                'user_id' => auth()->user()->id,
                'message' => 'Project - ' . $this->project($request->id)->project_name . ' with id - ' . $this->project($request->id)->project_id . ' has been ' . $request->status . ' ' . $this->user_details() . '.',
                'type' => 'notification',
                'title' => 'Project - ' . $this->project($request->id)->project_id
            ]));
            auth()->user()->notify(new ActionNotification($this->project($request->id), Auth::user(), $notification));
            if (Project::where(['id' => $request->id])->update(['status' => $request->status])) {
                return response()->json(updateMessage('Project status'));
            }
        } else {
            $activity = ProjectActivity::create([
                "project_id" => $request->id,
                "type_id" => "status",
                "text" => $notification,
                "user_id"   => Auth::user()->id,
            ]);
            broadcast(new SendMessage($this->project($request->id)));
            broadcast(new NotificationEvent([
                'user_id' => auth()->user()->id,
                'message' => 'Project - ' . $this->project($request->id)->project_name . ' with id - ' . $this->project($request->id)->project_id . ' has been ' . $request->status . ' ' . $this->user_details() . '.',
                'type' => 'notification',
                'title' => 'Project - ' . $this->project($request->id)->project_id
            ]));
            auth()->user()->notify(new ActionNotification($this->project($request->id), Auth::user(), $notification));
            $project = Project::where(['id' => $request->id, 'status' => 'close'])->first();
            if (!empty($project)) {
                Project::where(['id' => $request->id])->update(['status' => $request->status]);
                $respondents = CloseRespondent::where('project_id', '=', $request->id)->get();
                if (count($respondents) > 0) {
                    foreach ($respondents as $respondent) {
                        Respondent::create([
                            'client_browser' => $respondent->client_browser,
                            'device' => $respondent->device,
                            'end_ip' => $respondent->end_ip,
                            'id' => $respondent->id,
                            'project_id' => $project->id,
                            'project_link_id' => $respondent->project_link_id,
                            'starting_ip' => $respondent->starting_ip,
                            'status' => $respondent->status,
                            'supplier_id' => $respondent->supplier_id,
                            'supplier_project_id' => $respondent->supplier_project_id,
                            'user_id' => $respondent->user_id,
                        ]);
                    }
                    $respondents = CloseRespondent::where('project_id', '=', $request->id)->delete();
                }
                return response()->json(updateMessage('Project status'));
            }
            if (Project::where(['id' => $request->id])->update(['status' => $request->status])) {
                return response()->json(updateMessage('Project status'));
            }
            return response()->json(errorMessage());
        }
    }
    public function suppliers(Request $request, $id)
    {
        $project = Project::find($id);
        $projects = SupplierProject::where('project_id', $id);

        if (!empty($request->supplier)) {
            $projects = $projects->where('supplier_id', 'like', "%{$request->supplier}%");
        }
        if ($request->status !== 'all' && $request->status !== null) {
            $projects = $projects->where('status', (int)$request->status);
        }
        if ($project) {
            return Inertia::render('Project/Supplier', [
                'project' => new ProjectResource($project),
                'supplier_projects' => SupplierProjectResource::collection($projects->get()),
                'clients' => $this->clients,
                'status' => $this->status,
                'suppliers' => $this->suppliers,
            ]);
        }
        return redirect()->back();
    }
    public function  activity($id)
    {
        $project = Project::find($id);
        $projectActivities = ProjectActivity::where('project_id', $id)->orderBy('created_at', 'DESC')->paginate(10);


        if ($project) {
            return Inertia::render('Project/Activity', [
                'project' => new ProjectResource($project),
                'activities' => ActivityProjectResource::collection($projectActivities),
            ]);
        }
        return redirect()->back();
    }
    public function importId(Request $request)
    {
        if ($request->hasFile('file')) {
            if (Excel::import(new IdImport($request->id), $request->file('file')->store('files'))) {

                $activity = ProjectActivity::create([
                    "project_id" => $request->id,
                    "type_id" => "status",
                    "text" => "Project " . $this->project($request->id)->project_name . " import",
                    "user_id"   => Auth::user()->id,
                ]);
                broadcast(new SendMessage($this->project($request->id)));
                broadcast(new NotificationEvent([
                    'user_id' => auth()->user()->id,
                    'message' => 'Project - ' . $this->project($request->id)->project_name . ' with id - ' . $this->project($request->id)->project_id . ' was imported by ' . $this->user_details() . '.',
                    'type' => 'notification',
                    'title' => 'Project - ' . $this->project($request->id)->project_id
                ]));
                auth()->user()->notify(new ActionNotification($this->project($request->id), Auth::user(), "Project " . $this->project($request->id)->project_name . " import",));

                return response()->json(['success' => true, 'message' => 'Import file successfully']);
            }
            return response()->json(errorMessage());
        }
    }
    public function exportId($id)
    {
        $project = Project::find($id);
        if ($project) {
            $activity = ProjectActivity::create([
                "project_id" => $id,
                "type_id" => "status",
                "text" => "Project " . $project->project_name . " Export",
                "user_id"   => Auth::user()->id,
            ]);
            broadcast(new SendMessage($this->project($id)));
            broadcast(new NotificationEvent([
                'user_id' => auth()->user()->id,
                'message' => 'Project - ' . $this->project($id)->project_name . ' with id - ' . $this->project($id)->project_id . ' was exported by ' . $this->user_details() . '.',
                'type' => 'notification',
                'title' => 'Project - ' . $this->project($id)->project_id
            ]));
            auth()->user()->notify(new ActionNotification($this->project($id), Auth::user(), $this->project($id)->project_name . " export",));

            return Excel::download(new ExportIdExport($project->id), $project->project_id . '-' . $project->project_name . '.xlsx');
        }
    }
    public function report($id)
    {
        $project = Project::find($id);
        if ($project) {
            $activity = ProjectActivity::create([
                "project_id" => $id,
                "type_id" => "status",
                "text" =>  $project->project_name . " report download",
                "user_id"   => Auth::user()->id,
            ]);
            broadcast(new SendMessage($this->project($id)));
            broadcast(new NotificationEvent([
                'user_id' => auth()->user()->id,
                'message' => 'Project - ' . $this->project($id)->project_name . ' with id - ' . $this->project($id)->project_id . ' was reported by ' . $this->user_details() . '.',
                'type' => 'notification',
                'title' => 'Project - ' . $this->project($id)->project_id
            ]));
            auth()->user()->notify(new ActionNotification($this->project($id), Auth::user(), $this->project($id)->project_name . " report download",));

            return Excel::download(new ProjectReport($id), $project->project_id . '-' . $project->project_name . '.xlsx');
        }
    }

    public function finalIds($id)
    {
        $project = Project::find($id);
        if (FinalId::where('project_id', $id)->first() && Respondent::where('project_id', $id)->first()) {
            return Excel::download(new ExportFinalIDs($id), $project->project_id . '-' . $project->project_name . '.xlsx');
        }
    }
}
