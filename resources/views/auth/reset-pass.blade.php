@extends('layouts.app')

@section('content')
<div class="w-[30%] mx-auto flex justify-center items-center h-screen">
   <div>
   <form class="reset-form mt-3" action="" method="post">
    @csrf
    <div>
        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Reset password</label>
        <div class="mt-2">
          <input id="password" name="password" type="password" autocomplete="password" class="px-1.5 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
        </div>
      </div>
      <button class="bg-indigo-700 py-2 px-3 mt-3 text-white rounded" type="submit">Set Password</button>
   </form>
   </div>
  </div>
@endsection

@push('scripts')
    <script>
    const resetForm = document.querySelector('.reset-form ');

    resetForm.addEventListener('submit',(e)=>{
        
        e.preventDefault();

        const password = document.querySelector('#password').value;

        resetPass(password);
      
    })


   async function resetPass(password) { 

    if(password.length === 0){
           errorToast('Please enter your new Password')
           return;
        }
        else{
          showLoader();
            let res = await axios.post('/reset-password', {password: password});
            hideLoader();
           
            if(res.status===200 && res.data['status']==='success'){
                
              success('pass reset success')
            
                setTimeout(function (){
                    window.location.href = '/login';
                }, 1000)
            }
            else{
                hideLoader();
                errorToast('went wrong')
            }

    }

  }

    </script>
@endpush