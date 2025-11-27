<ul id="sortable" class="sort_display_order sortable-products"> 
    @foreach($products as $key => $product)
    <li class="ui-state-default" id="{{$product->id}}">
        <div class="product-list-item">
            <div class="photo-50">
                <img src="{{$product->photo}}" alt="" style="width:50px">
            </div>
            <div class="name-product">
                {{$product->name}}
            </div>
            <input type="hidden" data-id="{{$product->id}}" value="{{$key + 1}}" class="value_order">
        </div>
    </li> 
    @endforeach
</ul> 