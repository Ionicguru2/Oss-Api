<?php namespace App\Http\Controllers\api\v1;

use Auth;
use Mandrill;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\ReportType;
use App\Models\Report;

class ReportController extends Controller {

    /**
     * The property holds current authenticated user.
     *
     * @var \App\Models\User
     */
    protected $current_user;


    /**
     * Constructor will initialize the class with basic properties.
     */
    public function __construct()
    {
        $this->current_user = Auth::getUser();
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$reports = Report::with('report_type')->orderBy('created_at','desc')->get();
        return $reports;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		$message = $request->input('message');
        $report_type_id = $request->input('report_type_id');

        if(!$message || !$report_type_id)
			return $this->prepareResponse('BAD_REQUEST');

        $report_type = ReportType::find($report_type_id);
		$report = Report::create(['message' => $message, 'report_type_id' => $report_type->id, 'user_id' => $this->current_user->id]);

        Mandrill::send_email('admin', 'report.new',
            [   'build_from_oss_config' => true,
                'report'=> $report,
                'user'  => $this->current_user,
                'report_type' => $report_type]);

		return $this->prepareResponse('report.CREATED');

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$report = Report::with('report_type')->where('id', '=', $id)->first();

        if(!$report)
			return $this->prepareResponse('report.NOT_FOUND_ER');
 
        return $report->toArray();
	}

}
