@extends('layouts.admin_default')
@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_attendance_list.css') }}">
@endsection

@section('content')
    <div class="attendance_group">
        <div class="attendance_title">
            <h2>2023年6月1日の勤怠</h2>
        </div>
        <div class="attendance_day">
            <span>
                <p>←前月</p>
            </span>
            <p>📅2023/6/1</p>
            <span>
                <p>翌月→</p>
            </span>
        </div>

        <div class="attendance_table">
            <table>
                <tr>
                    <th>名前</th>
                    <th>出勤</th>
                    <th>退勤</th>
                    <th>休憩</th>
                    <th>合計</th>
                    <th>詳細</th>
                </tr>
                <tr>
                    <td>山田太郎</td>
                    <td>9:00</td>
                    <td>18:00</td>
                    <td>1:00</td>
                    <td>8:00</td>
                    <td><a href="/admin/attendance/id">詳細</a></td>
                </tr>
                <tr>
                    <td>西伶奈</td>
                    <td>9:00</td>
                    <td>18:00</td>
                    <td>1:00</td>
                    <td>8:00</td>
                    <td><a href="/admin/attendance/id">詳細</a></td>
                </tr>
            </table>
        </div>
    </div>

@endsection