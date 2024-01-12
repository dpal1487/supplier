<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Company;
use App\Models\Country;
use App\Models\CompanySize;
use Illuminate\Http\Request;
use App\Models\CompanyAccount;
use App\Models\CompanyAddress;
use App\Http\Controllers\Controller;
use App\Http\Resources\AccountResource;
use App\Http\Resources\AddressResource;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\CountryResource;
use App\Models\Account;
use App\Models\Address;
use App\Models\CorporationType;


class CompanyController extends Controller
{
    public $countries, $status, $address, $company;
    public function __construct()
    {
        $this->countries = CountryResource::collection(Country::orderBy('name', 'asc')->get());
        $this->address = Address::where(['entity_id' => Company::first()->id, 'entity_type' => 'company'])->first();
        $this->company = new CompanyResource(Company::first());
    }

    public function show()
    {
        return Inertia::render('Company/Overview', [
            'company' => $this->company,
            'address' => new AddressResource($this->address),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
            'tax_number' => 'required',
            'description' => 'required',
        ]);
        $company = Company::where('id', $request->id)->first();
        $update = $company->update([
            'company_name' => $request->company_name,
            'tax_number' => $request->tax_number,
            'description' => $request->description,
        ]);
        if ($update) {
            return redirect("/company")->with('flash', ['message' => 'Company successfully updated.']);
        }
        return redirect()->back()->withErrors(['Opps something went wrong!']);
    }
    public function address()
    {
        if ($this->address) {
            return Inertia::render('Company/Address', [
                'address' => new AddressResource($this->address),
                'company' => $this->company,
                'countries' => $this->countries
            ]);
        } else {
            return Inertia::render('Company/Address', [
                'company' => $this->company,
                'countries' => $this->countries
            ]);
        }
    }

    public function updateAddress(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required',
        ]);
        if (Company::where(['id' => $request->company_id])->first()) {
            if ($address = Address::where(['entity_id' => $request->company_id, 'entity_type' => 'company'])->first()) {
                $update = $address->update([
                    'address' => $request->address,
                    'entity_id' => $request->company_id,
                    'entity_type' => 'company',
                    'city' => $request->city,
                    'state' => $request->state,
                    'country_id' => $request->country,
                    'pincode' => $request->pincode,
                ]);
                if ($update) {
                    return redirect("/company/address")->with('flash', updateMessage('Address'));
                }
                return redirect("/company/address")->with('flash', errorMessage());
            } else {
                $create = Address::create([
                    'address' => $request->address,
                    'entity_id' => $request->company_id,
                    'entity_type' => 'company',
                    'city' => $request->city,
                    'state' => $request->state,
                    'country_id' => $request->country,
                    'pincode' => $request->pincode,
                ]);
                if ($create) {
                    return redirect("/company/address")->with('flash', createMessage('Address'));
                }
                return redirect("/company/address")->with('flash', errorMessage());
            }
            return redirect()->back()->withErrors(['Opps something went wrong!']);
        }
        return redirect()->back();
    }

    public function account()
    {
        $account = Account::first();
        if ($account) {
            return Inertia::render('Company/Account', [
                'account' => new AccountResource($account),
                'company' => $this->company,
                'address' => $this->address,
            ]);
        } else {
            return Inertia::render('Company/Account', [
                'company' => $this->company,
                'address' => $this->address,
            ]);
        }
    }

    public function updateAccount(Request $request)
    {
        $request->validate([
            'bank_name' => 'required',
            'bank_address' => 'required',
            'beneficiary_name' => 'required',
            'account_number' => 'required',
            'routing_number' => 'required',
            'swift_code' => 'required',
            'ifsc_code' => 'required',
            'sort_code' => 'required',
        ]);
        $account = Account::where(['id' => 1])->update([
            'bank_name' => $request->bank_name,
            'bank_address' => $request->bank_address,
            'beneficiary_name' => $request->beneficiary_name,
            'account_number' => $request->account_number,
            'routing_number' => $request->routing_number,
            'swift_code' => $request->swift_code,
            'ifsc_code' => $request->ifsc_code,
            'sort_code' => $request->sort_code,
        ]);
        if ($account) {

            return redirect("/company/account")->with('flash', ['message' => 'Account successfully updated.']);
        }
        return redirect()->back()->withErrors(['Opps something went wrong!']);
    }
}
