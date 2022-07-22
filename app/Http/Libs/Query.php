<?php

namespace App\Libs;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Query
{

	static public function find($table, Request $req, $empresa = false, $local = false, $withs = [], $count = false)
	{
		$filters = is_null($req->input('filter')) ? false : $req->input('filter');
		$selects = is_null($req->input('select')) ? '*' : array_keys($req->input('select'));
		$isNulls = is_null($req->input('isnull')) ? false : array_keys($req->input('isnull'));
		$order = is_null($req->input('order')) ? [] : $req->input('order');
		$limit = is_null($req->input('limit')) ? false : $req->input('limit');
		$json = is_null($req->input('json')) ? false : $req->input('json');

		$table = $table->select($selects);

		if ($filters) {
			foreach ($filters as $key => $value) {
				if (count($value) == 5) {
					$table->whereRaw("JSON_VALUE( " . $value[0] . " , " . $value[1] . ") " . $value[2] . " JSON_VALUE( " . $value[3] . " , " . $value[4] . ")");
				} else {
					if ($value[1] == 'in') {
						$table->whereIn($value[0], array_values($value[2]));
					} else if ($value[1] == 'not in') {
						$table->whereNotIn($value[0], array_values($value[2]));
					} else if ($value[1] == 'is null') {
						$table->WhereNull($value[0]);
					} else {
						if (isset($value[3]) && $value[3] == 'or') {
							$table->orWhere([[$value[0], $value[1], $value[2]]]);
						} else {
							$table->where([[$value[0], $value[1], $value[2]]]);
						}
					}
				}
			}
		}

		while ($nomb = current($order)) {
			if ($nomb == 'ASC' || $nomb == 'DESC') {
				$table->orderBy(key($order), $nomb);
			}
			next($order);
		};

		if ($withs) {
			foreach ($withs as $key => $value) {
				$table->with([$key => function ($q) use ($value) {
					if (count($value)) {
						foreach ($value as $quey => $balue) {
							$q->with($balue);
						}
					} else {
						return $q;
					}
				}]);
			}
		}

		if ($local) {
			$table->where('local_id', $local);
		}

		if ($empresa) {
			$table->where('empresa_id', $empresa);
		}
		//dd($table->toSql());

		if ($limit) {
			return $table->paginate($limit);
		}

		return ['data' => $table->get()];
	}

	static public function Before($table, $query, $count = false)
	{

		$table = DB::table($table);

		$filters = !isset($query["filter"]) ? false : $query['filter'];
		$selects = !isset($query["select"]) ? '*' : array_keys($query['select']);
		$order = !isset($query["order"]) ? [] : $query['order'];
		$limit = !isset($query["limit"]) ? false : $query['limit'];
		$json = !isset($query["json"]) ? false : $query['json'];

		if ($filters) {
			foreach ($filters as $key => $value) {
				if (count($value) == 5) {
					$table = $table->whereRaw("JSON_VALUE( " . $value[0] . " , " . $value[1] . ") " . $value[2] . " JSON_VALUE( " . $value[3] . " , " . $value[4] . ")");
				} else {
					$table = $table->where([[$value[0], $value[1], $value[2]]]);
				}
			}
		}

		while ($nomb = current($order)) {
			if ($nomb == 'ASC' || $nomb == 'DESC') {
				$table = $table->orderBy(key($order), $nomb);
			}
			next($order);
		};
		// dd($table->toSql());
		if ($limit) {
			return $table;
		}

		return $table;
	}

	//
	// no usar en la version de laravel 8
	//
	public function checkValvue($value)
	{
		//check si es numero
		if (is_numeric($value)) {
			return floatval($value);
		}
		return $value;
	}
}
