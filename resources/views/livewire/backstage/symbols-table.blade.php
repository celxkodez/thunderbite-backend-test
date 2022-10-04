<div>
    @include('backstage.partials.tables.top')
    <div class="flex flex-col">
        <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div class="align-middle inline-block min-w-full overflow-hidden">
                <table class="min-w-full">
                    @include('backstage.partials.tables.headers')

                    <tbody class="bg-white">
                    @if(count($rows))
                        @foreach($rows as $key => $row)
                            <tr class="@if( ($key+1) % 2 === 0 ) alternate @endif">

                                <td class="px-6 py-3 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900">
                                    {{$row->name}}
                                </td>
                                <td class="px-6 py-3 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900">
                                    <img src="{{$row->image}}" height="30" width="30" alt="">
                                </td>
                                <td class="px-6 py-3 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900 ">
                                    {{$row->match_point_3}}
                                </td>
                                <td class="px-6 py-3 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900">
                                    {{$row->match_point_4}}
                                </td>
                                <td class="px-6 py-3 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900">
                                    {{$row->match_point_5}}
                                </td>
                                <td class="px-6 py-3 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900">
                                    {{$row->status}}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="px-6 py-3 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900 text-center" colspan="{{ count($columns) }}">No data</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('backstage.partials.tables.footer')
</div>
