<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Users;
use Illuminate\Support\Facades\DB;
use DataTables;
use Image;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {   
        if ($request->ajax()) {
            $data = DB::table('employee')->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $url_edit = url('editEmployee/'.$row->id.'/edittEmployee');
                    $url_del = url('deleteEmployee/'.$row->id.'/deletteEmployee');
                    $actionBtn = '<a href='.$url_edit.'  class="btn btn-primary btn-sm">Edit</a> <a href='.$url_del.' class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
    } 
    return view('home');
}

public function companyList(Request $request)
{   
    if ($request->ajax()) {
        $data = DB::table('Company')->latest()->get();
        $data = DB::table('Company')
            ->join('employee', 'Company.emp_id', '=', 'employee.id')
            ->select('Company.*', 'employee.first_name', 'employee.last_name')
            ->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('c_logo', function ($rows) { 
                $url= asset('storage/logo/'.$rows->c_logo);
               
                return '<img src='.$url.' border="0" width="50px" height="50px" class="img-rounded" align="center" />'; 
         })
            ->addColumn('action', function($row){
                $url_edit = url('editCompany/'.$row->id.'/edittCompany');
                $url_del = url('deleteCompany/'.$row->id.'/deletteCompany');
                $actionBtn = '<a href='.$url_edit.'  class="btn btn-primary btn-sm">Edit</a> <a href='.$url_del.' class="delete btn btn-danger btn-sm">Delete</a>';
                return $actionBtn;
            })
            ->rawColumns(['c_logo','action'])
            ->make(true);
}
return view('companyList');
}

    public function logout()
    {
        Auth::logout();

        //return redirect('admin/');
        return redirect('/');
    } 

    public function edittEmployee($id) 
    {
        
        $data = DB::table('employee')->where('id', $id)->first();
    //  print_r($data);exit;
        
            return view('updateEmployee', compact('data'));
        
    }

    public function deletteEmployee($id) 
    {
        
        $data = DB::table('employee')->where('id', $id)->delete();
   
        
            return view('home');
        
    }

    public function editpostEmployee(Request $request)
    {
        
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|max:12',
            'email' => 'required|email|unique:users'
        ], [
            'first_name.required' => 'First Name is required',
            'last_name.required' => 'Last Name is required'
        ]);
// print_r($validatedData);exit;
DB::table('employee')->where('id', $request['empID'])->update([
    'first_name' => $request['first_name'],
    'last_name'  => $request['last_name'],
    'email'  => $request['email'],
    'phone'  => $request['phone'],
    'updated_at'  => date("Y-m-d h:i:s")
]);
  
    return back()->with('success', 'Employee updated successfully.');
    }

    public function addEmployee()
    {
        
        return view('addEmployee');
    }

    public function addpostEmployee(Request $request)
    {
        
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|max:12',
            'email' => 'required|email|unique:users'
        ], [
            'first_name.required' => 'First Name is required',
            'last_name.required' => 'Last Name is required'
        ]);
// print_r($validatedData);exit;
DB::table('employee')->insert([
    'first_name' => $request['first_name'],
    'last_name'  => $request['last_name'],
    'email'  => $request['email'],
    'phone'  => $request['phone'],
    'created_at'  => date("Y-m-d h:i:s")
]);
  
    return back()->with('success', 'Employee created successfully.');
    }
    
    public function addCompany()
    {
       $getEmployee = DB::table('employee')->get();
        return view('addCompany',compact('getEmployee'));
    } 

    public function addpostCompany(Request $request)
    {
        
        $validatedData = $request->validate([
            'c_name' => 'required',
            'emp_id' => 'required',
            'c_email' => 'required|email|unique:Company',
            'c_phone' => 'required|max:12',
            'c_website' => 'required',
            'c_logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            
        ], [
            'c_name.required' => 'Company Name is required',
            'emp_id.required' => 'Employee Name is required',
            'c_email.required' => 'Company Email is required',
            'c_phone.required' => 'Company Phone is required',
            'c_website.required' => 'Company Website is required',
            'c_logo.required' => 'Company logo is required',
        ]); 

    if($request->hasFile('c_logo')) {
        $image = $request->file('c_logo');
        
        $destination_path = 'public/logo';
        $logo = $request->file('c_logo');
        $logo_name = $logo->getClientOriginalName();
        $path = public_path('logo/'.$logo_name);
        Image::make($image->getRealPath())->resize(100, 100)->save($path);
        $path = $request->file('c_logo')->storeAs($destination_path,$logo_name);
        
    }

    DB::table('Company')->insert([

    'c_name' => $request['c_name'],
    'emp_id'  => $request['emp_id'],
    'c_email'  => $request['c_email'],
    'c_phone'  => $request['c_phone'],
    'c_website'  => $request['c_website'],
    'c_logo'  => $logo_name,
    'created_at'  => date("Y-m-d h:i:s")
]);
    return back()->with('success', 'Company added to Employee created successfully.');
}  

public function edittCompany($id)
{
    $data = DB::table('Company')->where('id', $id)->first();
    //  print_r($data);exit;
    $getEmployee = DB::table('employee')->get();
  //  print_r($getEmployee);exit;
    return view('updateCompany', compact('data','getEmployee'));
    
}

public function editpostCompany(Request $request)
    {
        $validatedData = $request->validate([
            'c_logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            
        ], [
            'c_logo.required' => 'Company logo is required'
        ]); 

    if($request->hasFile('c_logo')) {
        $doc = DB::table('Company')->where('id',$request['c_id'])->first();
          // dd($doc);exit;
            $file_path = storage_path().'/app/public/logo/'.$doc->c_logo;
         //  echo($file_path);exit;
            // You can also check existance of the file in storage.
            if(!empty($doc->c_logo)) {
               unlink('/var/www/html/MyProject/storage/app/public/logo/'.$doc->c_logo);
            }

        $destination_path = 'public/logo';
        $logo = $request->file('c_logo');
        $logo_name = $logo->getClientOriginalName();
        $path = $request->file('c_logo')->storeAs($destination_path,$logo_name);
        
    }

    DB::table('Company')->where('id', $request['c_id'])->update([

    'c_name' => $request['c_name'],
    'emp_id'  => $request['emp_id'],
    'c_email'  => $request['c_email'],
    'c_phone'  => $request['c_phone'],
    'c_website'  => $request['c_website'],
    'c_logo'  => $logo_name,
    'updated_at'  => date("Y-m-d h:i:s")
]);
    return back()->with('success', 'Details updated successfully.');
}  

public function deletteCompany($id) 
    {
        
        $data = DB::table('Company')->where('id', $id)->delete();
   
        
            return view('companyList');
        
    }

}
