@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="container">
<div class="row justify-content-center m-4">
    <h4>Task (2)</h4>
laravel 8 framework
create products page to show all items from dummy.sql using ajax with loadmore ajax button.
create filter form with distinct values of category , brands checkboxes
add an input text to filter form to search for products that matches same name or same category or same brand name
</div>
<hr/>
    <form id="filterForm">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="search">Search:</label>
                    <input type="text" id="search" class="form-control" placeholder="Search by name, category, or brand">
                </div>
            </div>
            <div class="col-md-4">

                <div class="form-group">
                    <label for="category">Category:</label><br>
                    @foreach ($categories as $category)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input categoryCheckbox" type="checkbox" id="category_{{ $category }}" value="{{ $category }}">
                        <label class="form-check-label" for="category_{{ $category }}">{{ $category }}</label>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="brand">Brand:</label><br>
                    @foreach ($brands as $brand)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input brandCheckbox" type="checkbox" id="brand_{{ $brand }}" value="{{ $brand }}">
                        <label class="form-check-label" for="brand_{{ $brand }}">{{ $brand }}</label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </form>



    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Brand</th>
                <!-- Add more table headings for other product details if needed -->
            </tr>
        </thead>
        <tbody id="productTableBody">
            @include('products.partials.products', ['products' => $products])
        </tbody>
    </table>

    <button id="loadMore">Load More</button>

</div>
@endsection

@section('script')
<script>
    var page = 1;
    $('#loadMore').click(function() {
        page++;
        $.ajax({
            url: '/products',
            type: 'GET',
            data: {
                page: page
            },
            success: function(data) {
                $('#productTableBody').append(data);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    function applyFilters() {
        var search = $('#search').val();
        var categories = $('.categoryCheckbox:checked').map(function() {
            return this.value;
        }).get();
        var brands = $('.brandCheckbox:checked').map(function() {
            return this.value;
        }).get();

        $.ajax({
            url: '/products/filter',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                search: search,
                category: categories,
                brand: brands
            },
            success: function(response) {
                $('#productTableBody').html(response.data);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    $('#filterForm').submit(function(event) {
        event.preventDefault();
        applyFilters();
    });

    $('#search').on('input', function() {
        applyFilters();
    });

    $('.categoryCheckbox, .brandCheckbox').change(function() {
        applyFilters();
    });
</script>
@endsection