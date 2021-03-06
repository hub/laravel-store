<div>
    @include('categories.tree.post', [
        'name' => $category->name,
        'id' => $category->id,
        'slug' => $category->slug,
    ])

    @if (count($category->children))
        <div class="sub">
            @each('categories.tree.listing', $category->children, 'category')
        </div>
    @else
        {{--  <div class="sub">
            <div style="margin-left:15px; color:#575757;">(пусто)</div>
        </div>  --}}
    @endif
</div>