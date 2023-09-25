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
        <section class="content">
            @if (session('status'))
                <div class="alert alert-{{session('type')}}">
                    {{ session('status') }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header">
                            <h1 class="box-title">Logger exercise.</h1>
                        </div>
                        <div class="box-body">
                            <form method="post" action="{{ route('log_controller.edit') }}">
                                {{ csrf_field() }}
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Minimum level for logging system</label>
                                            <select class="form-control" name="minimum_level">
                                            @foreach ($levelTextArray as $key => $level)
                                                <option value="{{$key}}"
                                                @if ($key == $currentMinimLevel)
                                                    selected="selected"
                                                @endif
                                                >{{ucfirst($level)}}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h4>Target settings</h4>
                                @foreach ($targetLogManager as $tlm)
                                    <div class="row mt-2">
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <input class="form-control" style="margin-top: 25px;" type="text" value="{{ucfirst($tlm->log_name)}}" readonly disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Target</label>
                                                <select class="form-control" name="target_{{$tlm->id}}">
                                                <option value="">Nothing selected</option>
                                                @foreach ($existingHandlers as $h)
                                                    <option value="{{$h}}"
                                                    @if ($h == $tlm->target)
                                                        selected="selected"
                                                    @endif
                                                    >{{$h}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Minimum level for target</label>
                                                <select class="form-control" name="minimum_level_for_{{$tlm->id}}">
                                                @foreach ($levelTextArray as $key => $level)
                                                    <option value="{{$key}}"
                                                    @if ($key == $tlm->minimum_level_for_target)
                                                        selected="selected"
                                                    @endif
                                                    >{{ucfirst($level)}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label style="margin-top: 25px;"> 
                                                    <input type="checkbox" name="is_dedicated_{{$tlm->id}}"
                                                    @if ($tlm->is_dedicated_target)
                                                        checked
                                                    @endif
                                                    /> <b>Is dedicated just for one target</b>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="row mt-5">
                                    <div class="col-md-12">
                                        <input type="submit" class="btn btn-primary" name="sbmtbtn" value="Edit">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  

</body></html>