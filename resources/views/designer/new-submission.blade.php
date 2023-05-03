@section('custom-scripts')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    @vite(['resources/js/designer/dropzone.js'])
    <script type="text/javascript">
        let pdf_img         = "{{ asset('images/pdf.png') }}";
        let excel_img       = "{{ asset('images/excel.png') }}";
        let upload_img      = "{{ asset('images/upload.png') }}";
        let delete_img      = "{{ asset('images/delete.png') }}";
        let green_tick      = "{{ asset('images/green-tick.png') }}";
        let dots_loading    = "{{ asset('images/dots-loading.gif') }}";
        let submission_code = "{{ $submission->submission_code }}";
    </script>
@endsection

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('dashboard.designer') }}">{{ __('Designer Dashboard') }}</a> - Add new submission
            {{ $submission->submission_code }}
        </h2>
    </x-slot>

    <div class="pt-12">
        
        <x-error-message error="" />

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="mb-4 text-gray-700">Please upload your files to start your submission</h3>
                    <form action="{{ route('designer.upload') }}" method="POST" enctype="multipart/form-data"
                        id="file-upload" class="dropzone flex flex-col">
                        @csrf
                    </form>
                </div>
            </div>
        </div>

        <div class="mt-12 pb-12 max-w-7xl mx-auto hidden sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div id="submission-feedback" class="p-6 text-gray-900">
                    
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
