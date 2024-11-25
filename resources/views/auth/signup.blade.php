@extends('layout.head')
<body>
    
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-xl xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-prior md:text-2xl dark:text-white">
                        Create an account
                    </h1>        
                    <form action="/signup" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="flex items-center mb-6">
                            <div class="shrink-0 me-6">
                                <img id="preview_img" class="h-16 w-16 object-cover rounded-full" src="{{ asset('storage/asset/profile.png') }}" alt="Current profile photo" />
                            </div>
                            <label for="file-upload" class="cursor-pointer block">
                                <div class="block w-full px-4 py-2 text-sm font-semibold text-center text-white bg-prior rounded-full hover:bg-second">
                                    Upload File
                                </div>
                                <input id="file-upload" name="file" type="file" accept="image/png, image/jpg" onchange="loadFile(event)" class="hidden" />
                            </label>
                            @error('file')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oh, snapp!</span> {{$message}}</p>
                            @enderror
                        </div>                        
                        <div class="mb-6">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Full name</label>
                            <input type="text" id="name" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('name') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-50 @enderror" placeholder="John Doe" required />
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oh, snapp!</span> {{$message}}</p>
                            @enderror
                        </div> 
                        <div class="mb-6">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email address</label>
                            <input type="email" id="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('email') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-50 @enderror" placeholder="john.doe@company.com" required />
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oh, snapp!</span> {{$message}}</p>
                            @enderror
                        </div> 
                        <div class="mb-6">
                            <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                            <input type="text" id="role" name="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('role') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-50 @enderror" placeholder="Web Programmer" required />
                            @error('role')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oh, snapp!</span> {{$message}}</p>
                            @enderror
                        </div> 
                        <div class="mb-6">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('password') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-50 @enderror" placeholder="•••••••••" required />
                            @error('password')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oh, snapp!</span> {{$message}}</p>
                            @enderror
                        </div> 
                        <p class="text-sm font-light mb-4 text-gray-500 dark:text-gray-400">
                            Already have an account? <a href="/signin" class="font-medium text-prior hover:underline dark:text-primary-500">Sign In</a>
                        </p>
                        <button type="submit" class="text-white bg-prior hover:bg-second focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Sign Up</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        var loadFile = function(event) {
            var input = event.target;
            var file = input.files[0];
    
            var allowedTypes = ['image/png', 'image/jpg', 'image/jpeg'];
            if (!allowedTypes.includes(file.type)) {
                alert('Only PNG and JPG files are allowed!');
                input.value = ''; 
                return;
            }
    
            var output = document.getElementById('preview_img');
            output.src = URL.createObjectURL(file);
            output.onload = function() {
                URL.revokeObjectURL(output.src); 
            };
        };
    </script>
</body>