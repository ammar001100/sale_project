@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>

                <div id="app">
                    <example-component></example-component>
                </div>

            </div>
        </div>

        <div class="card card-primary card-outline">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>

                <p class="card-text">
                    Some quick example text to build on the card title and make up the bulk of the card's
                    content.
                </p>
                <button type="button" class="btn btn-success swalDefaultSuccess">
                    Launch Success Toast
                </button>
                <button type="button" class="btn btn-info swalDefaultInfo">
                    Launch Info Toast
                </button>
                <button type="button" class="btn btn-danger swalDefaultError">
                    Launch Error Toast
                </button>
                <button type="button" class="btn btn-warning swalDefaultWarning">
                    Launch Warning Toast
                </button>
                <button type="button" class="btn btn-default swalDefaultQuestion">
                    Launch Question Toast
                </button>
            </div>
        </div><!-- /.card -->
    </div>
    <!-- /.col-md-6 -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="m-0">Featured</h5>
            </div>
            <div class="card-body">
                <h6 class="card-title">Special title treatment</h6>

                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>

        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="m-0">Featured</h5>
            </div>
            <div class="card-body">
                <h6 class="card-title">Special title treatment</h6>

                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    </div>
    <!-- /.col-md-6 -->
</div>
<!-- /.row -->
@endsection