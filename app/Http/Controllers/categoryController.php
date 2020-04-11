<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Http\Controllers\Input;
use App\Category;
use App\Demand;
use DB;
use App\Http\Requests\categoryRequest;

//use Illuminate\Foundation\Auth\ConfirmsPasswords;

use Illuminate\Foundation\Auth\AuthenticatesUsers; // used for checking for password here
use Illuminate\Foundation\Auth\RegistersUsers;     // used for checking for password match


use Illuminate\Support\Facades\Validator;          // in order to use class validator
use mysql_xdevapi\Session;


class categoryController extends Controller
{

    use AuthenticatesUsers;
    //use RegistersUsers;
    //use ConfirmsPasswords;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        //
        $info = $request->session()->all()["login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d"];

        $date = date('Y-m-d');
        $time = date('H:i:s');
        $categories = Category::all();

        if ($info != 1)
            session()->push('X', $info);

        if (count($categories) == 0) {
            session()->push('m', 'success');
            session()->push('m', 'There are no categories stored yet!');
        }
		//dd($categories->available);

        return view('scoutViews.categories')->withDate($date)->withTime($time)->withCategories($categories);
		
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        //
        $category_name = $request->input('category_name');
        $available = $request->input('available');
        $total = $request->input('available');
        $file = $request->file('image');
        $destinationPath = 'images';

        if ($category_name == "") $category_name = "Untitled Category";
        if ($available == "") {
            $available = 0;
            $total = 0;
        }
        if ($file == null) $filename = "untitled.jpg";
        else if ($file != null) {
            $filename = $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
        }

        $new_category = new Category;
        $new_category->category_name = $category_name;
        $new_category->image_name = $filename;
        $new_category->total = $total;
        $new_category->available = $available;
        $new_category->save();

        session()->push('m', 'success');
        session()->push('m', 'Your category has been added successfully!');
        return redirect('add_category');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $info = $request->session()->all();
        $user_id = $info ["login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d"];

        for ($i = 1; $i <= (count($request->all()) - 1) / 2; $i++) {
            $category_id = $request->get($i);
            $demand = $request->get($i . "_quantity");
            if ($demand != null) {
                DB::transaction(function () use ($demand, $user_id, $category_id, $request) {
                    DB::table('demands')->insert(['user_id' => $user_id, 'category_id' => $category_id,
                        'demand' => $demand]);

                    session()->push('m', 'success');
                    session()->push('m', 'Your Request has been sent successfully!');
                    return redirect('categories');

                });
            } else {
                session()->push('m', 'danger');
                session()->push('m', 'Your Request was empty!');
                return redirect('categories');
            }
        }

    }

    public function X(Request $request)
    {
        //

        $info = $request->session()->all() ["login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d"];
        var_dump($info);
        dd("hello");
        $new = $request->get("new");
        //dd($new);

//        $user_id = $info ["login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d"];
//
//        for ($i = 1; $i <= (count($request->all()) - 1) / 2; $i++) {
//            $category_id = $request->get($i);
//            $demand = $request->get($i . "_quantity");
//            if ($demand != null) {
//                DB::transaction(function () use ($demand, $user_id, $category_id, $request) {
//                    DB::table('demands')->insert(['user_id' => $user_id, 'category_id' => $category_id,
//                        'demand' => $demand]);
//
//                    session()->push('m', 'success');
//                    session()->push('m', 'Your Request has been sent successfully!');
//                    return redirect('categories');
//
//                });
//            } else {
//                session()->push('m', 'danger');
//                session()->push('m', 'Your Request was empty!');
//                return redirect('categories');
//            }
//        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function demands(Request $request)
    {
        //
        if ($request->session()->all()["login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d"] != 1) {
            session()->push('m', 'danger');
            session()->push('m', 'You are not allowed to view this page as you are not an admin!');
            return redirect('categories');
        } else {
            $date = date('Y-m-d');
            $time = date('H:i:s');

            $demands = DB::table('demands')
                ->join('users', 'user_id', '=', 'users.id')
                ->where('Accepted', 2)
                ->select('users.name', 'users.id')
                ->distinct()
                ->get();

            if (count($demands) == 0) {
                session()->push('m', 'success');
                session()->push('m', 'There are no demands to display!');
            }
            return view('scoutViews.demands', compact('demands',
                $demands), ['date' => $date, 'time' => $time]);
        }
    }

    public function notifications(Request $request)
    {
        $info = $request->session()->all()["login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d"];
        $X = 1;

        if ($info == 1) {
            $id = $request->get("id");
            $date = date('Y-m-d');
            $time = date('H:i:s');
            $notifications = DB::table('demands')
                ->join('users', 'user_id', '=', 'users.id')
                ->join('categories', 'demands.category_id', '=', 'categories.id')
                ->where('Accepted', 2)
                ->where('user_id', $id)
                ->select('categories.category_name', 'categories.available', 'users.name', 'demands.demand', 'demands.id')
                ->get();

            for ($i = 0; $i < count($notifications); $i++) {
                if (((array)$notifications[$i])['demand'] > ((array)$notifications[$i])['available']) $X = 0;
            }

            if (count($notifications) == 0) {
                session()->push('m', 'success');
                session()->push('m', 'There are no notifications to display!');
            }
            return view('scoutViews.notifications', ['notifications' => $notifications, 'date' => $date, 'time' => $time, 'id' => $id, 'X' => $X]);

        } else {
            $date = date('Y-m-d');
            $time = date('H:i:s');

            $notifications = DB::table('demands')
                ->join('users', 'user_id', '=', 'users.id')
                ->join('categories', 'demands.category_id', '=', 'categories.id')
                ->where('seen_by_user', '0')
                ->where('user_id', $info)
                ->select('categories.category_name', 'categories.available', 'users.name', 'demands.demand', 'demands.id', 'demands.Accepted')
                ->get();

            if (count($notifications) == 0) {
                session()->push('m', 'success');
                session()->push('m', 'There are no notifications to display!');
            }
            return view('scoutViews.notifications_user', ['notifications' => $notifications, 'date' => $date, 'time' => $time]);
        }
    }

    public function add_category(Request $request)
    {
        //
        if ($request->session()->all()["login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d"] != 1) {
            session()->push('m', 'danger');
            session()->push('m', 'You are not allowed to view this page as you are not an admin!');
            return redirect('categories');
        } else {
            $date = date('Y-m-d');
            $time = date('H:i:s');
            $categories = Category::withTrashed()->get();

            return view('scoutViews.add_category', ['categories' => $categories, 'date' => $date, 'time' => $time]);
        }
    }

    public function notifications_user_ack(Request $request, $id)
    {
        $info = $request->session()->all();
        $user_id = $info ["login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d"];

        DB::table('demands')->where('id', $id)->update(['seen_by_user' => 1]);

        $notifications = DB::table('demands')
            ->join('users', 'user_id', '=', 'users.id')
            ->join('categories', 'demands.category_id', '=', 'categories.id')
            ->where('seen_by_user', '0')
            ->where('user_id', $user_id)
            ->select('categories.category_name', 'categories.available', 'users.name', 'demands.demand', 'demands.id', 'demands.Accepted')
            ->get();

        if (count($notifications) == 0) {
            session()->push('m', 'success');
            session()->push('m', 'There are no notifications to display!');
        }
        return redirect('notifications');
    }

    public function cancel_request(Request $request, $id)
    {
        $info = $request->session()->all();
        $user_id = $info ["login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d"];

        DB::table('demands')->where('id', $id)->delete();

        $notifications = DB::table('demands')
            ->join('users', 'user_id', '=', 'users.id')
            ->join('categories', 'demands.category_id', '=', 'categories.id')
            ->where('seen_by_user', '0')
            ->where('user_id', $user_id)
            ->select('categories.category_name', 'categories.available', 'users.name', 'demands.demand', 'demands.id', 'demands.Accepted')
            ->get();

        if (count($notifications) == 0) {
            session()->push('m', 'success');
            session()->push('m', 'There are no notifications to display!');
        }
        return redirect('notifications');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $category_name2 = $request->input('category_name2');
        $total2 = $request->get('total2');
        $available2 = $request->get('available2');

        if ($total2 < $available2) $available2 = $total2;

        Category::where('id', $id)->update(['category_name' => $category_name2, 'total' => $total2, 'available' => $available2]);

        session()->push('m', 'success');
        session()->push('m', 'Category updated successfully!');
        return redirect('add_category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->session()->all()["login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d"] != 1) {
            session()->push('m', 'danger');
            session()->push('m', 'You are not allowed to view this page as you are not an admin!');
            return redirect('categories');
        } else {
            Category::where('id', $id)->delete();
            session()->push('m', 'danger');
            session()->push('m', 'Category deleted temporarily!');
            return redirect('add_category');
        }
    }

    public function accept_all_notification(Request $request)
    {
        //
        $X = 1;
        if ($request->session()->all()["login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d"] != 1) {
            session()->push('m', 'danger');
            session()->push('m', 'You are not allowed to view this page as you are not an admin!');
            return redirect('categories');
        } else {
            $id = $request->get("id");
            $date = date('Y-m-d');
            $time = date('H:i:s');

            DB::table('demands')->where('user_id', $id)->where('Accepted', 2)->update(['Accepted' => 1]);

            $notifications = DB::table('demands')
                ->join('users', 'user_id', '=', 'users.id')
                ->join('categories', 'demands.category_id', '=', 'categories.id')
                ->where('Accepted', 2)
                ->where('user_id', $id)
                ->select('categories.category_name', 'categories.available', 'users.name', 'demands.demand', 'demands.id')
                ->get();

            session()->push('m', 'success');
            session()->push('m', 'There are no notifications from that user to display');
        }
        return view('scoutViews.notifications', ['notifications' => $notifications, 'date' => $date, 'time' => $time, 'id' => $id, 'X' => $X]);
    }


    public function delete_all_notification(Request $request)
    {
        //
        $X = 1;
        if ($request->session()->all()["login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d"] != 1) {
            session()->push('m', 'danger');
            session()->push('m', 'You are not allowed to view this page as you are not an admin!');
            return redirect('categories');
        } else {
            $date = date('Y-m-d');
            $time = date('H:i:s');
            $id = $request->get("id");

            DB::table('demands')->where('user_id', $id)->where('Accepted', 2)->update(['Accepted' => 0]);

            $notifications = DB::table('demands')
                ->join('users', 'user_id', '=', 'users.id')
                ->join('categories', 'demands.category_id', '=', 'categories.id')
                ->where('Accepted', 2)
                ->where('user_id', $id)
                ->select('categories.category_name', 'categories.available', 'users.name', 'demands.demand', 'demands.id')
                ->get();

            for ($i = 0; $i < count($notifications); $i++) {
                if (((array)$notifications[$i])['demand'] > ((array)$notifications[$i])['available']) $X = 0;
            }

            if (count($notifications) == 0) {
                session()->push('m', 'success');
                session()->push('m', 'There are no notifications from that user to display!');
            } else {
                session()->push('m', 'danger');
                session()->push('m', 'Demand rejected successfully!');
            }
            return view('scoutViews.notifications', ['notifications' => $notifications, 'date' => $date, 'time' => $time, 'id' => $id, 'X' => $X]);
        }
    }

    public function accept_notification(Request $request)
    {
        //
        $X = 1;
        if ($request->session()->all()["login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d"] != 1) {
            session()->push('m', 'danger');
            session()->push('m', 'You are not allowed to view this page as you are not an admin!');
            return redirect('categories');
        } else {
            $date = date('Y-m-d');
            $time = date('H:i:s');

            $demand_id = $request->get("demand_id");
            $id = $request->get("id");
            $value1 = DB::table('demands')->where('id', $demand_id)->select('category_id')->first();
            $category_id = $value1->category_id;
            $value2 = DB::table('categories')->where('id', $category_id)->select('available')->first();
            $available = $value2->available;
            $value3 = DB::table('demands')->where('id', $demand_id)->select('demand')->first();
            $demand = $value3->demand;

            DB::table('demands')->where('id', $demand_id)->update(['Accepted' => 1]);
            DB::table('categories')->where('id', $category_id)->update(['available' => $available - $demand]);

            $notifications = DB::table('demands')
                ->join('users', 'user_id', '=', 'users.id')
                ->join('categories', 'demands.category_id', '=', 'categories.id')
                ->where('Accepted', 2)
                ->where('user_id', $id)
                ->select('categories.category_name', 'categories.available', 'users.name', 'demands.demand', 'demands.id')
                ->get();

            for ($i = 0; $i < count($notifications); $i++) {
                if (((array)$notifications[$i])['demand'] > ((array)$notifications[$i])['available']) $X = 0;
            }
            if (count($notifications) == 0) {
                session()->push('m', 'success');
                session()->push('m', 'There are no notifications from that user to display');
            } else {
                session()->push('m', 'success');
                session()->push('m', 'Demand Accepted successfully!');
            }
            return view('scoutViews.notifications', ['notifications' => $notifications, 'date' => $date, 'time' => $time, 'id' => $id, 'X' => $X]);
        }
    }

    public function delete_notification(Request $request)
    {
        //
        $X = 1;
        if ($request->session()->all()["login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d"] != 1) {
            session()->push('m', 'danger');
            session()->push('m', 'You are not allowed to view this page as you are not an admin!');
            return redirect('categories');
        } else {
            $date = date('Y-m-d');
            $time = date('H:i:s');
            $demand_id = $request->get("demand_id");
            $id = $request->get("id");

            DB::table('demands')->where('id', $demand_id)->update(['Accepted' => 0]);

            $notifications = DB::table('demands')
                ->join('users', 'user_id', '=', 'users.id')
                ->join('categories', 'demands.category_id', '=', 'categories.id')
                ->where('Accepted', 2)
                ->where('user_id', $id)
                ->select('categories.category_name', 'categories.available', 'users.name', 'demands.demand', 'demands.id')
                ->get();

            for ($i = 0; $i < count($notifications); $i++) {
                if (((array)$notifications[$i])['demand'] > ((array)$notifications[$i])['available']) $X = 0;
            }

            if (count($notifications) == 0) {
                session()->push('m', 'success');
                session()->push('m', 'There are no notifications from that user to display');
            } else {
                session()->push('m', 'danger');
                session()->push('m', 'Demand rejected successfully!');
            }

            return view('scoutViews.notifications', ['notifications' => $notifications, 'date' => $date, 'time' => $time, 'id' => $id, 'X' => $X]);
        }
    }

    public function restore(Request $request, $id)
    {
        if ($request->session()->all()["login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d"] != 1) {
            session()->push('m', 'danger');
            session()->push('m', 'You are not allowed to view this page as you are not an admin!');
            return redirect('categories');
        } else {
            Category::where('id', $id)->restore();
            session()->push('m', 'info');
            session()->push('m', 'Category restored successfully!');
            return redirect('add_category');
        }
    }

    public function deleteForever(Request $request, $id)
    {
        if ($request->session()->all()["login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d"] != 1) {
            session()->push('m', 'danger');
            session()->push('m', 'You are not allowed to view this page as you are not an admin!');
            return redirect('categories');
        } else {
            Category::where('id', $id)->forceDelete();
            session()->push('m', 'danger');
            session()->push('m', 'Category deleted Permanently!');
            return redirect('add_category');
        }
    }

//    public function match(Request $request)
//    {
//        dd("H");
//
//        $request->validate($this->rules(), $this->validationErrorMessages());
//
//        $this->resetPasswordConfirmationTimeout($request);
//
//        return redirect()->intended($this->redirectPath());
//    }

    public function match(Request $request)
    {

        dd($this->validator($request->all())->validate());
		//$this->validator($request->all())->validate();
dd("5");
//        event(new Registered($user = $this->create($request->all())));
//
//
//        $this->guard()->login($user);
//
//        return $this->registered($request, $user)
//            ?: redirect($this->redirectPath());
    }

    protected function validator(array $data)
    {

        return Validator::make($data, [
           
           'new' => ['string', 'min:8', 'confirmed'],
        ]);


    }

//    protected function validationErrorMessages()
//    {
//        //dd("H");
//        return [];
//    }
//
//    protected function rules()
//    {
//        return [
//            'new' => 'required|password',
//        ];
//    }

//    protected function resetPasswordConfirmationTimeout(Request $request)
//    {
//        dd("H");
//        $request->session()->put('auth.password_confirmed_at', time());
//    }

}
