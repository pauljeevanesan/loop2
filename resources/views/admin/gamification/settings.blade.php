@extends('layouts.admin')

@section('title', $page_title)

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $page_title }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.gamification.settings.update') }}" method="POST">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Setting / Action</th>
                                        <th>Value / Points</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($settings as $action_name => $setting)
                                        <tr>
                                            <td>{{ $setting->display_name }}</td>
                                            <td>
                                                <input type="number" class="form-control" name="settings[{{ $action_name }}][points]" value="{{ $setting->points }}">
                                            </td>
                                            <td>
                                                @if ($action_name !== 'points_to_currency_rate')
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="settings[{{ $action_name }}][is_active]" value="1" @if($setting->is_active) checked @endif>
                                                    <label class="form-check-label">
                                                        {{ $setting->is_active ? 'Active' : 'Inactive' }}
                                                    </label>
                                                </div>
                                                @else
                                                    <span class="badge bg-info">System Setting</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Save Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
