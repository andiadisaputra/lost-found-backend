<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Http\Requests\Report\StoreReportRequest;
use App\Http\Requests\Report\UpdateReportRequest;
use App\Http\Resources\ReportResource;
use App\Services\Report\ReportService;
use App\Traits\ApiResponse;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected ReportService $reportService
    ) {}

    public function store(StoreReportRequest $request)
    {
        $report = $this->reportService->store(
            $request->validated(),
            $request->user()
        );

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dibuat.',
            'data' => new ReportResource($report)
        ], 201);
    }

    public function index(Request $request)
    {
        $reports = $this->reportService->index(
            $request->only(['search', 'type', 'status', 'category_id'])
        );

        return ReportResource::collection($reports);
    }

    public function show(Report $report)
    {
        return new ReportResource(
            $this->reportService->show($report)
        );
    }

    public function update(UpdateReportRequest $request, Report $report)
    {
        if ($request->user()->id !== $report->user_id) {
            return $this->error('Anda tidak berhak mengubah laporan ini.', 403);
        }

        $report = $this->reportService->update(
            $report,
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil diperbarui.',
            'data' => new ReportResource($report)
        ]);
    }

    public function destroy(Request $request, Report $report)
    {
        if ($request->user()->id !== $report->user_id) {
            return $this->error('Anda tidak berhak menghapus laporan ini.', 403);
        }

        $this->reportService->delete($report);

        return $this->success('Laporan berhasil dihapus.');
    }

    public function myReports(Request $request)
    {
        $reports = $this->reportService->myReports(
            $request->user()->id,
            $request->only(['search', 'type', 'status', 'category_id'])
        );

        return ReportResource::collection($reports);
    }
}
