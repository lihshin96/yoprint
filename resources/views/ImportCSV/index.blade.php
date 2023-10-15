@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header" style="background: gray; color:#f1f7fa; font-weight:bold;">
                    Import CSV File
                </div> -->
                 <div class="card-body">                    
                    <form class="w-px-500 p-3 p-md-3" action="{{ route('importCSV.import') }}" method="post" enctype="multipart/form-data" id="csv-upload">
                        @csrf
                        <div class="row" class="dropzone" id="myDropzone">
                            <div class="col-md-6">
                                <input type="file" id="csv-file-input" name="csv_file" readonly style="display: none;">
                                <h4 id="dragndrop-file-info">Drag & Drop your CSV file here</h4>
                            </div>
                            <div class="col-md-6">
                                <button 
                                id="csv-upload-btn"
                                type="submit" 
                                class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded no-dropzone"
                                style="float: right;">
                                    Upload File
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>Time</th>
                <th>File Name</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($uploadHistory as $history)
            <tr data-id="{{ $history->id }}">
                <td class="created_at-cell">{{ $history->created_at }}</td>
                <td class="file_name-cell">{{ $history->file_name }}</td>
                <td class="status-cell">
                    @php
                        $statusMap = [
                                0 => 'Pending',
                                1 => 'Processing',
                                2 => 'Completed',
                                3 => 'Failed',
                            ];
                        $statusString = $statusMap[$history->status];
                    @endphp
                    {{ $statusString }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script type="text/javascript">

// Enable pusher logging - don't include this in production
// Pusher.logToConsole = true;

var pusher = new Pusher('395c3f9950fb5605244a', {
  cluster: 'ap1'
});

window.Echo.channel('upload-history')
    .listen('RefreshUploadHistory', (data) => {
        if(data) {
            var rowData = data.data

            updateTable(rowData);
        }        
    });

// Dropzone configuration
Dropzone.autoDiscover = false;
const dropzone = new Dropzone('#myDropzone', {
    url: "{{ route('importCSV.import') }}",
    paramName: "file",
    thumbnailWidth: 1000,
    maxFilesize: 1024, // Max file size in MB
    acceptedFiles: ".csv", // Allowed file types
    clickable: "#myDropzone", // Make the entire Dropzone clickable
    autoProcessQueue: false,
    init: function () {
        const fileInfoDiv = document.getElementById('dragndrop-file-info');
        const csvFileInput = document.getElementById('csv-file-input');

        this.on("addedfile", function (file) {
            // Show the file name in the custom div
            fileInfoDiv.innerHTML = `File Name: <b>${file.name}</b><br/>File Size: <b>${formatBytes(file.size)}</b>`;

            // Create a FileList containing the selected file
            const fileList = new DataTransfer();
            fileList.items.add(file);

            // Update the file input's files with the FileList
            csvFileInput.files = fileList.files;
        });
    },
});

// Prevent the "Upload File" button from triggering file selection
// const uploadButton = document.getElementById('csv-upload-btn');
// uploadButton.addEventListener("click", (e) => {
//     e.preventDefault();
// });

// Function to format file size in human-readable format
function formatBytes(bytes) {
    if (bytes === 0) return '0 Bytes';

    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

    const i = parseInt(Math.floor(Math.log(bytes) / Math.log(k)), 10);

    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function updateTable(data) {
    const row = document.querySelector(`tr[data-id="${data.id}"]`);
    if (row) {
        row.querySelector('.status-cell').textContent = getStatusText(data.status);
    }
}

function getStatusText(status) {
    const statusMap = {
        0: 'Pending',
        1: 'Processing',
        2: 'Completed',
        3: 'Failed',
    };

    return statusMap[status] || 'Pending';
}
</script>
<style type="text/css">
/* Hide the success and error marks */
.dz-success-mark, .dz-error-mark, .dz-preview, .dz-file-preview {
    display: none;
}
#myDropzone {
    border: 2px dashed #c7c7c7;
    border-radius: 5px;
    background-color: #f4f4f4;
    padding: 20px;
    text-align: center;
    cursor: pointer;
}
</style>

@endsection