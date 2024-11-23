@if (isset($data) && $data->count() > 0)
    @php
        $i = 1;
    @endphp
    <table class="table table-bordered table-hover">
        <thead class="custom_thead">
            <tr class="custom_thead">
                <th>مسلسل</th>
                <th>اسم الخزنة</th>
                <th>نوع الخزنة</th>
                <th>حالة التفعيل</th>
                <th>اخر اصال صرف</th>
                <th>اخر اصال تحصيل</th>
                <th>الاجراءت</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $info)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $info->name }}</td>
                    <td>
                        @if ($info->is_master == 1)
                            رئيسية
                        @else
                            فرعية
                        @endif
                    </td>
                    <td>
                        @if ($info->active == 1)
                            مفعل
                        @else
                            غير مفعل
                        @endif
                    </td>
                    <td>{{ $info->last_isal_exhcange }}</td>
                    <td>{{ $info->last_isal_collect }}</td>
                    <td>
                        <a href="{{ route('admin.treasuries.edit', $info->id) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-pencil-alt"></i></a>
                        <a href="{{ route('admin.treasuries.show', $info->id) }}" data-id="{{ $info->id }}"
                            class="btn btn-sm btn-primary">
                            <i class="fas fa-eye"></i></a>
                    </td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
        </tbody>
    </table>
    <br>
    <div class="col-md-12" id="ajax_pagination_in_search">
        {{ $data->links() }}
    </div>
    <br>
@else
    <div class="card_title_center">
        <p class="btn btn-danger btn-sm">
            عفوا لاتوجد بيانات
        </p>
    </div>
@endif
