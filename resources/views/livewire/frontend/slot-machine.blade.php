<div x-data="app()">
    @if($errors->any())
        <div class="notification-container" style="">
            @foreach ($errors->all() as $error)
                <p style="color: #f30202">{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <div class="row">
{{--        <div class="col-12">--}}
{{--            <p>Hello Welcome</p>--}}
{{--        </div>--}}

        <form action="">
            <div class="col-12">
                <table>
                    @foreach($reel as $reel_row)
                        <tr>
                            @foreach($reel_row as $reel_item)
                                <td>
                                    <img width="50px" height="50px" src="{{\App\Models\SymbolId::find($reel_item)->image}}" alt="">
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </table>
                <p>{{$prefix}}</p>
                <p>Points: <span>{{$total_points}}</span></p>

                <button wire:click="spin" type="button" class="spinBtn">Spin</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        function app() {
            return {

            }
        }
    </script>
@endpush
