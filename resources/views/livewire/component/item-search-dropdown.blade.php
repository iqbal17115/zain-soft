@push('css')
<style>
    .custom-search-dropdown {
        z-index: 10001;
    }

</style>
@endpush
<div>
    <form class="mt-4 mt-sm-0 form-inline ">
        <div class="search-box mr-2">
            <div class="position-relative">
                {{-- <label class="form-label float-left">Enter Barcode Scan/Product Code</label><br> --}}
                <input type="text" wire:model.debounce.500ms="search" class="form-control border-1"
                    placeholder="Enter Barcode Scan/Product Code">
                <i class="bx bx-search-alt search-icon"></i>
                @if (strlen($search) >= 2)
                <div class="custom-search-dropdown position-absolute text-center rounded mt-1">
                    <div class="list-group">
                        @if ($search_list->count() > 0)
                            @foreach ($search_list as $item)
                            <a href="javascript:void(0)" class="list-group-item list-group-item-action" wire:click="searchSelect({{$item}})">{{$item->code}}</a>
                            @endforeach
                            @else
                            <a href="javascript:void(0)" class="list-group-item list-group-item-action">No result found for {{$search}}</a>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
        {{-- <ul class="nav nav-pills product-view-nav">
            <li class="nav-item">
                <a class="nav-link active" href="#"><i class="bx bx-grid-alt"></i></a>
            </li>
        </ul> --}}
    </form>
</div>
