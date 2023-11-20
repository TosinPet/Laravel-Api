<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportCustomer;
use App\Exports\ExportCustomerAccount;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Imports\CustomersAccountImport;
use App\Imports\CustomersImport;
use App\Models\CustomerAccount;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    //
    public function index()
    {
        $customers = Customer::where('account', true)->get();
        // dd($customers);
        return view('admin.customer.index', compact('customers'));
    }

    public function createCustomer(Request $request)
    {
        if($request->isMethod('post'))
        {
            try {
                // dd($request);

                $request->validate([
                    'full_name' => 'bail|required|string',
                    'address' => 'bail|required|string',
                    'year_of_business' => 'bail|required|string',
                    'business_type' => 'bail|required|string',
                    'business_name' => 'bail|required|string',
                    'phone' => 'bail|required|string',
                    'state' => 'bail|required|string',
                    'lga' => 'bail|required|string',
                    'customer_type' => 'bail|required|string',
                    'status' => 'nullable|integer',
                    'suspend' => 'nullable|integer',                
                    'guarantor_name' => 'bail|nullable|string',
                    'guarantor_address' => 'bail|nullable|string',
                    'guarantor_phone' => 'bail|nullable|string',
                    'relationship_with_applicant' => 'bail|nullable|string',
                    'years_of_relationship' => 'bail|nullable|string'
                ]);
                // dd($request);
                $pass = random_int(100000, 999999);
                $password = bcrypt($pass);
                $ref = 'CUS'.random_int(1000000000, 9999999999);
                $customer = Customer::create([
                    'user_id' => auth()->user()->id,
                    'full_name' => $request->full_name,
                    'address' => $request->address,
                    'year_of_business' => $request->year_of_business,
                    'business_type' => $request->business_type,
                    'business_name' => $request->business_name,
                    'phone' => $request->phone,
                    'state' => $request->state,
                    'lga' => $request->lga,
                    'customer_type' => $request->customer_type,
                    'reference_no' => $ref,
                    'active' => $request->active ?? 0,
                    'suspend' => $request->suspend ?? 0,
                    'guarantor_name' => $request->guarantor_name,
                    'guarantor_address' => $request->guarantor_address,
                    'guarantor_phone' => $request->guarantor_phone,
                    'relationship_with_applicant' => $request->relationship_with_applicant,
                    'years_of_relationship' => $request->years_of_relationship,
                    'password' => $password,
                    'created_by' => auth()->user()->id,
                ]);

                $user = User::create([
                    'full_name' => $request->full_name,
                    'phone' => $request->phone,
                    'reference_no' => $ref,
                    'password' => $password,
                ]);
                // dd($pass);
                

                // if($request->is_approved && $request->is_approved == 1 && $affiliate->is_approved == 0)
                // {
                    // Log::info('affiliate');
                    // try{
                    //     Mail::to($user)->queue(new AffiliateWelcomeEmail($affiliate, $pass));
                    // } catch (\Exception $e)
                    // {
                    //     Log::info($e->getMessage());
            
                    // }
                // }

                return redirect()->back()->with('success', "Customer has been created successfully.");
            } catch (ValidationException $th) {
                return back()->with('danger', $th->validator->errors()->first())->withInput();
            } catch (\Throwable $th) {
                return back()->with('danger', $th->getMessage())->withInput();
            }
        }else{
            try
            {
                return view('admin.customer.create');
            } catch(\Exception $e)
            {
                // dd($e->getMessage());
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }

    public function updateCustomer(Request $request, $customer_id)
    {   
        try {
            $request->validate([
                'full_name' => 'bail|nullable|string',
                'address' => 'bail|nullable|string',
                'business_type' => 'bail|nullable|string',
                'business_name' => 'bail|nullable|string',
                'state' => 'bail|nullable|string',
                'lga' => 'bail|nullable|string',
                'customer_type' => 'bail|nullable|string',
                'status' => 'nullable|integer',
                'suspend' => 'nullable|integer',                
            ]);

            $customer = Customer::find($customer_id);

            $customer->update([
                'full_name' => $request->full_name,
                'address' => $request->address,
                'business_type' => $request->business_type,
                'state' => $request->state,
                'lga' => $request->lga,
                'customer_type' => $request->customer_type,
                'active' => $request->active ?? 0,
                'suspend' => $request->suspend ?? 0,
                'last_edited_by' => auth()->user()->id,
            ]);


            return redirect()->back()->with('success', "Customer has been edited successfully.");
        } catch (ValidationException $th) {
            return back()->with('danger', $th->validator->errors()->first());
        } catch (\Throwable $th) {
            return back()->with('danger', $th->getMessage());
        }
    }

    public function importCustomer(Request $request)
    {
        try{
            if(!$request->hasFile('csv_file'))
            {
                return redirect()->back()->with('danger', 'Please select an csv file');
            }

            $import = Excel::import(new CustomersImport(), request()->file('csv_file'));
            if($import)
            {
                // dd($import);
                return redirect()->back()->with('success', 'Customer List imported successfully');

            }else{

                return redirect()->back()->with('danger', 'Not imported successfully');
            }

        } catch (ValidationException $e)
        {
            return redirect()->back()->with('danger', $e->validator->errors()->first());
        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage());

        }
        
    }

    public function exportCustomer(Request $request)
    {
        try{
            return Excel::download(new ExportCustomer, 'customers.xlsx');

        } catch (ValidationException $e)
        {
            return redirect()->back()->with('danger', $e->validator->errors()->first());
        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage());

        }
        
    }

    public function accountStatement()
    {
        $customers_account = CustomerAccount::get();
        // dd($customers_account);
        foreach($customers_account as $account)
        {
            $customer_id = $account->customer_id;
            $customer = Customer::find($customer_id);

            $account->credit_allowance = $account->credit_limit - $account->utilized_credit;
            $account["full_name"] = $customer->full_name;

            // dd($account->credit_allowance);
        }
        return view('admin.customer.account.index', compact('customers_account'));
    }

    public function importCustomerAccount(Request $request)
    {
        try{
            if(!$request->hasFile('csv_file'))
            {
                return redirect()->back()->with('danger', 'Please select an csv file');
            }

            $import = Excel::import(new CustomersAccountImport(), request()->file('csv_file'));
            if($import)
            {
                // dd($import);
                return redirect()->back()->with('success', 'Customers Account List imported successfully');

            }else{

                return redirect()->back()->with('danger', 'Not imported successfully');
            }

        } catch (ValidationException $e)
        {
            return redirect()->back()->with('danger', $e->validator->errors()->first());
        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage());

        }
        
    }

    public function exportCustomerAccount(Request $request)
    {
        try{
            return Excel::download(new ExportCustomerAccount, 'customers_account.xlsx');

        } catch (ValidationException $e)
        {
            return redirect()->back()->with('danger', $e->validator->errors()->first());
        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage());

        }
        
    }

    public function updateCustomerAccount(Request $request, $account_id)
    {   
        try {
            $request->validate([
                'utilized_credit' => 'bail|nullable|integer',
                'credit_limit' => 'bail|nullable|integer',
                'credit_allowance' => 'bail|nullable|integer',               
            ]);

            $customers_account = CustomerAccount::find($account_id);

            $customers_account->update([
                'utilized_credit' => $request->utilized_credit,
                'credit_limit' => $request->credit_limit,
                'credit_allowance' => $request->credit_allowance,
            ]);


            return redirect()->back()->with('success', "Customer's List has been edited successfully.");
        } catch (ValidationException $th) {
            return back()->with('danger', $th->validator->errors()->first());
        } catch (\Throwable $th) {
            return back()->with('danger', $th->getMessage());
        }
    }

    public function createCustomerDeposit(Request $request)
    {
        if($request->isMethod('post'))
        {
            try {
                // dd($request);
                $request->validate([
                    'customer' => 'required',
                    'deposit_date' => 'bail|required|string',
                    'description' => 'bail|required|string',
                    'amount' => 'bail|required|string',
                    'mode_of_payment' => 'bail|required|string',
                ]);
                // dd($request);
                $receipt = random_int(10000000000, 99999999999);
                $customer = Customer::create([
                    'receipt_no' => $receipt,
                    'deposit_date' => $request->deposit_date,
                    'description' => $request->description,
                    'amount' => $request->amount,
                    'mode_of_payment' => $request->mode_of_payment,
                    'created_by' => auth()->user()->id,
                ]);

                return redirect()->back()->with('success', "Customer Deposit has been created successfully.");
            } catch (ValidationException $th) {
                return back()->with('danger', $th->validator->errors()->first())->withInput();
            } catch (\Throwable $th) {
                return back()->with('danger', $th->getMessage())->withInput();
            }
        }else{
            try
            {
                $customers = Customer::all();
                // dd($customers);
                $customers_account = CustomerAccount::all();
                return view('admin.customer.deposit.create', compact('customers', 'customers_account'));
            } catch(\Exception $e)
            {
                // dd($e->getMessage());
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }
    
    
    
    
}

