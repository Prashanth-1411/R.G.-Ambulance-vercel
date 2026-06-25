<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\FuneralBooking;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class MonthlyBookingsChart extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $dateExpr = DB::getDriverName() === 'pgsql'
            ? "TO_CHAR(created_at, 'YYYY-MM')"
            : "DATE_FORMAT(created_at, '%Y-%m')";

        $ambulanceData = Booking::select(DB::raw("$dateExpr as month"), DB::raw('count(*) as total'))
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();

        $funeralData = FuneralBooking::select(DB::raw("$dateExpr as month"), DB::raw('count(*) as total'))
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();

        $months = $ambulanceData->pluck('month')->merge($funeralData->pluck('month'))->unique()->sort()->values();

        return $table
            ->query(
                Booking::whereRaw('1 = 0')
            )
            ->columns([
                TextColumn::make('month')->label('Month'),
                TextColumn::make('ambulance_count')->label('Ambulance Bookings'),
                TextColumn::make('funeral_count')->label('Funeral Bookings'),
            ])
            ->emptyStateHeading('No booking data yet');
    }
}
