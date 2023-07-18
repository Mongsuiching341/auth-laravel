@extends('layouts.app')

@section('content')
<div class="w-[30%] mx-auto flex justify-center items-center h-screen">
   <div>
   <form class="verify-form mt-3" action="" method="post">
    @csrf
    <div>
        <label for="otp" class="block text-sm font-medium leading-6 text-gray-900">Otp code</label>
        <div class="mt-2">
          <input id="otp" name="otp" type="text" autocomplete="email" class="px-1.5 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
        </div>
      </div>
      <button class="bg-indigo-700 py-2 px-3 mt-3 text-white rounded" type="submit">Verify</button>
   </form>
   </div>
  </div>
@endsection

@push('scripts')
    <script>
    const verifyForm = document.querySelector('.verify-form ');

    verifyForm.addEventListener('submit',(e)=>{
        
        e.preventDefault();

        const otp = document.querySelector('#otp').value;

        verifyOtp(otp);
      
    })


   async function verifyOtp(otp) { 

    if(otp.length === 0){
           errorToast('Please enter your otp')
           return;
        }
        else{
          showLoader();
            let res = await axios.post('/verify-otp', {otp: otp,email: sessionStorage.getItem('email')});
            hideLoader();
            if(res.status===200 && res.data['status']==='success'){
              success('verified otp')
            
                
              sessionStorage.removeItem('email');
              window.location.href = '/reset-password';
              
            }
            else{
                hideLoader();
                errorToast('went wrong')
            }

    }

  }

    </script>
@endpush