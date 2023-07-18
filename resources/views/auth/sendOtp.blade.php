@extends('layouts.app')

@section('content')
<div class="w-[30%] mx-auto flex justify-center items-center h-screen">
   <div>
    <h2 class="text-3xl">Forgot your password</h2>
   <p class="mt-3">Enter email address and we will send you a otp code to reset your password.</p>
   <form class="otp-form mt-3" action="" method="post">
    @csrf
    <div>
        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
        <div class="mt-2">
          <input id="email" name="email" type="email" autocomplete="email" class="px-1.5 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
        </div>
      </div>
      <button class="bg-indigo-700 py-2 px-3 mt-3 text-white rounded" type="submit">Send otp</button>
   </form>
   </div>
  </div>
@endsection

@push('scripts')
    <script>
    const otpForm = document.querySelector('.otp-form ');

    otpForm.addEventListener('submit',(e)=>{
        
        e.preventDefault();

        const email = document.querySelector('#email').value;

        sendOtp(email);
      
    })


   async function sendOtp(email) { 

    if(email.length === 0){
           errorToast('Please enter your email address')
           return;
        }
        else{
          showLoader();
            let res = await axios.post('/forgot-password', {email: email});
            hideLoader();
            if(res.status===200 && res.data['status']==='success'){
              success('sent otp')
                sessionStorage.setItem('email', email);
                setTimeout(function (){
                    window.location.href = '/verify-otp';
                }, 1000)
            }
            else{
                errorToast('went wrong')
            }

    }

  }

    </script>
@endpush