@extends('admin.layout')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold text-[#0A2540]">Education Content</h1>

        <div class="mt-6 flex gap-6 items-start">

            <div class="w-1/4 flex flex-col bg-white rounded-xl shadow-md p-6">
                <form action="/admin/edukasi" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <div class="img">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                        <input type="file" name="image" id="image"
                            class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#0A2540] file:text-white hover:file:bg-[#081c33]">
                    </div>

                    <div class="judul">
                        <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" id="judul" name="judul" placeholder="Enter Your Content Title"
                            class=" px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A2540] focus:border-transparent transition"
                            required />
                    </div>

                    <div class="content">
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                        <textarea type="text" id="content" name="content" placeholder="Enter Your Content"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A2540] focus:border-transparent transition"
                            required></textarea>
                    </div>

                    <div class="">
                        <button button type="submit"
                            class=" bg-[#0A2540] text-white py-2 my-2 px-4 rounded-lg hover:bg-opacity-90 transition duration-200 font-medium">Upload</button>
                    </div>
                </form>
            </div>

            <div class=""></div>
        </div>
    </div>
@endsection