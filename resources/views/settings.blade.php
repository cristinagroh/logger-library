<html lang="en"><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/cover/">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>

  <body class="text-left">

    <div class="cover-container d-flex h-100 p-3 mx-auto flex-column">
        <main role="main" class="inner cover mt-5">
            <h1 class="cover-heading">Logger exercise.</h1>
        </main>
        <form method="post" action="{{ route('log_controller.edit') }}">
            {{ csrf_field() }}
            <div class="row mt-2">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Minimum level</label>
                        <select class="form-control" name="minimum_level">
                        @foreach ($levelTextArray as $level)
                            <option value="{{$level}}"
                            @if ($level == $currentMinimLevel)
                                selected="selected"
                            @endif
                            >{{$level}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12">
                    <input type="submit" class="btn btn-primary" name="sbmtbtn" value="Edit">
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  

</body></html>