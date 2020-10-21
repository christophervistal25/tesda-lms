@if(Session::has('errors'))
  <div class="card bg-danger text-white shadow mb-2">
    <div class="card-body">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  </div>
@endif