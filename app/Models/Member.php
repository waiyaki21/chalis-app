<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'name',
        'telephone',
        'amount_before',
        'welfare_before',
        'welfareowed_before',
        'active'
    ];

    protected $appends = [
        
        // 'welfare_sum',
        // 'welfare_owing',
        // PAYMENTS 
        'payments_sum',
        'payments_total',
        // WELFARES 
        'welfare_in',
        'total_in',
        'welfare_out',
        'welfare_total',
        // TOTALS 
        'total_investment',
        'total_shares'
    ];

    // PAYMENTS 
    public function payments(): HasMany
    {
        return $this->HasMany(Payment::class, 'member_id');
    }

    public function getPaymentsSumAttribute()
    {
        return $this->payments()->sum('payment');
    }

    public function getPaymentsTotalAttribute()
    {
        $info       = $this->hasOne(Member::class, 'id')->first();

        $before     = $info->amount_before;

        $all        = Payment::where('member_id', $info->id)
                                ->sum('payment');

        $total      = intval($before) + $all;

        return $total;
    }
    // END PAYMENTS 

    // WELFARES 
    public function welfares(): HasMany
    {
        return $this->HasMany(Welfare::class, 'member_id');
    }

    public function getWelfareSumAttribute()
    {
        return $this->welfares()->sum('payment');
    }

    public function getWelfareInAttribute()
    {
        $info    = $this->hasOne(Member::class, 'id')->first();

        $welfares    = Welfare::where('member_id', $info->id)
            ->where('type', 1)
            ->sum('payment');

        return $welfares;
    }

    public function getWelfareOutAttribute()
    {
        $info    = $this->hasOne(Member::class, 'id')->first();

        $welfares    = Welfare::where('member_id', $info->id)
            ->where('type', 0)
            ->sum('payment');

        $total = $welfares + $info->welfareowed_before;

        return $total;
    }

    public function getTotalInAttribute()
    {
        $info    = $this->hasOne(Member::class, 'id')->first();

        $welfares    = Welfare::where('member_id', $info->id)
            ->where('type', 1)
            ->sum('payment');

        $total = $welfares + $info->welfare_before;

        return $total;
    }

    public function getWelfareTotalAttribute()
    {
        $info           = $this->hasOne(Member::class, 'id')->first();

        $before         = $info->welfare_before;

        $beforeowed     = $info->welfareowed_before;

        $owes    = Welfare::where('member_id', $info->id)
                            ->where('type', 0)
                            ->sum('payment');

        $wels    = Welfare::where('member_id', $info->id)
                            ->where('type', 1)
                            ->sum('payment');
  
        $total = $before + $wels - $owes - $beforeowed;

        return $total; 
    }
    // END WELFARES 

    public function cycles(): HasMany
    {
        return $this->HasMany(Cycle::class);
    }

    public function lastPay()
    {
        return $this->hasOne(Payment::class)->with('cycle:id,name,amount,created_at')->latest();
    }

    public function getWelfareOwingAttribute()
    {
        // $members = Member::count();

        $info    = $this->hasOne(Member::class, 'id')->first();

        $welfares    = Welfare::where('member_id', $info->id)
            ->where('type', 0)
            ->sum('payment');

        $pays    = Payment::where('member_id', $info->id)
            ->sum('payment');

        $owing   = $welfares - $pays;

        if ($welfares > $pays) {
            $owing   = $welfares - $pays;
        } else {
            $owing   = 0;
        }

        return $owing;
    }

    public function getTotalInvestmentAttribute()
    {
        
        $info    = $this->hasOne(Member::class, 'id')->first();
        $member  = Member::where('id', $info->id)
                        ->first();

        $totalPays = $member->payments_total;

        $totalWelfare = $member->welfare_total;

        $grandTotal = $totalPays + $totalWelfare;

        return $grandTotal;
    }

    public function getTotalSharesAttribute()
    {
        // get finances 
        $finance = Finances::orderBy('created_at', 'desc')->first();

        $info    = $this->hasOne(Member::class, 'id')->first();
        $member  = Member::where('id', $info->id)
                        ->first();

        $totalInvestment = $member->total_investment;

        $finance_total = $finance->total_pays + $finance->total_welfare;

        if ($finance_total == 0) {
            $percentage = 0;
        } else {
            $percentage = $totalInvestment / $finance_total * 100;
        }

        return round($percentage, 3);
    }
}
