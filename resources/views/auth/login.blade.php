@extends('layouts.app')

@section('content')
    <!--
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
<!--
  This example requires updating your template:

  ```
  <html class="h-full bg-white">
  <body class="h-full">
  ```
-->
<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
      <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign in to your account</h2>
    </div>
  
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6 login-form" action="#" method="POST">
        <div>
          <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
          <div class="mt-2">
            <input id="email" name="email" type="email" autocomplete="email" class="px-1.5 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>
  
        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
            <div class="text-sm">
              <a href="{{route('forgot-password')}}" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
            </div>
          </div>
          <div class="mt-2">
            <input id="password" name="password" type="password" autocomplete="current-password" required class="px-1.5 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>
  
        <div>
          <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
        </div>
      </form>
  
      <p class="mt-10 text-center text-sm text-gray-500">
      Don't have account?
        <a href="{{route('register')}}" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Sign up</a>
      </p>
    </div>
  </div>
  
@endsection

@push('scripts')
    <script>
    const loginForm = document.querySelector('.login-form');

    loginForm.addEventListener('submit',(e)=>{
        e.preventDefault();
     
        const email = document.querySelector('#email').value;
        const password = document.querySelector('#password').value;
       
        
       loginUser(email,password);
      
    })

    async function loginUser(email,password){

if(email.length == 0){
    errorToast("email is required")
}else if(password.length == 0){
    errorToast("password is required")
}else{

  try {
    const res = await axios.post("/login",{
    email : email,
    password: password
})
console.log(res)

success('Login successfull');

window.location.href = "/dashboard";

  } catch (error) {
        errorToast('Incorrect E-mail or password');
    
  }



// if(res.status === 200  && res.data['status']==="success"){
   

//     //location to dashboard
// }else{
//     }
}

}

    </script>
@endpush