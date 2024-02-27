
@foreach ($products as $product)
            <tr>
                <td>{{ $product->product }}</td>
                <td>{{ $product->category }}</td>
                <td>{{ $product->brand }}</td>
                <!-- Add more table cells for other product details if needed -->
            </tr>
            @endforeach