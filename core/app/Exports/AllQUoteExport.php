<?php

namespace App\Exports;

use App\Quote;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;


class AllQUoteExport implements FromQuery,WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
	use Exportable;
	public function headings(): array
    {
        return [
            'Reference No',
            'Po Name',
            'Company Name',
            'Quote Price',
            'Date',
            'Status'
        ];
    }
	
	public function query()
    {
		$query =  Quote::query();
		$query->with(['quote_userprofile','quote_selectedtemplate'])->where('status','=',1);
		return $query;
    }
    public function map($quotes): array
    {
        return [
            $quotes->ref_no,
            $quotes->po_name,
			$quotes->quote_userprofile->company_name ? ucfirst($quotes->quote_userprofile->company_name) : '-',
            isset($quotes->quote_selectedtemplate->finalprice) && $quotes->quote_selectedtemplate->finalprice != '' ? $quotes->quote_selectedtemplate->finalprice : '-',
            date('m/d/yy',strtotime($quotes->updated_at)),
            $quotes->confirmed ? 'Confirmed' : 'Pending'
        ];
    }
}
