<style>
    .drive {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .drive li {
        background: #f9f9f9;
        border: 1px solid #ddd;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 8px;
        font-family: Arial, sans-serif;
        font-size: 14px;
    }

    .drive li iframe {
        width: 100%;
        max-width: 640px;
        height: 360px;
        border: none;
        margin-top: 10px;
        border-radius: 5px;
    }

    .drive li + li {
        margin-top: 5px;
    }

    .row {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }
</style>

<div class="row">
    <ul class="drive">
        @foreach($contents as $value)
            <li>Name: {{ $value['extra_metadata']['name'] }}</li>
            <li>Path: {{ $value['extra_metadata']['virtual_path'] }}</li>
            <li>Mime Type: {{ $value['mime_type'] }}</li>
            <li>Type: {{ $value['type'] }}</li>
            <li>File Size: {{ $value['file_size'] }}</li>

            <li>
                Download file cách 1:
                <a href="https://drive.google.com/file/d/{{ $value['extra_metadata']['virtual_path'] }}/view" target="_blank">Tải</a> 
            </li>

            <li>
                Download file cách 2:
                <a href="{{ url('/download-document', [ 'virtual_path' => $value['extra_metadata']['virtual_path'], 'name' => $value['extra_metadata']['name'] ]) }}">Tải</a> 
            </li>

            <li>Delete: <a href="{{ url('delete-document', ['virtual_path' => $value['extra_metadata']['virtual_path']]) }}">Xóa</a></li>

            <li>
                <iframe src="https://drive.google.com/file/d/{{ $value['extra_metadata']['virtual_path'] }}/preview" width="640" height="480" allow="autoplay"></iframe>
            </li>
            <hr style="border-top: 1px solid #000;">
        @endforeach
    </ul>
</div>