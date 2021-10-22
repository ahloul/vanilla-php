<?php declare(strict_types=1);

namespace App\Phone\Repositories\Classes;

use App\Enums\CountriesEnum;
use App\infra\BaseDBRepository;
use App\Phone\Repositories\Interfaces\PhoneRepositoryInterface;
use PDO;

class PhoneRepository extends BaseDBRepository implements PhoneRepositoryInterface
{
    public function getPhones(array $params): array
    {
        $page = 1;
        if (isset($params['page'])) {
            $page = $params['page'];
        }
        $itemsPerPage = 5;
        $offset = ($page - 1) * $itemsPerPage;


        $query = $this->buildQuery($params);

        $totalCount = $this->getTotalCountForQuery($query);

        $pages = ($totalCount % $itemsPerPage == 0) ? ($totalCount / $itemsPerPage) : (round($totalCount / $itemsPerPage) + 1);

        $query = $query . ' limit :offset,:items';
        $statement = $this->connection->prepare($query);

        $statement->bindValue('offset', $offset, \PDO::PARAM_INT);
        $statement->bindValue('items', $itemsPerPage, \PDO::PARAM_INT);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $pagination = [
            'page' => (int)$page,
            'total_items' => (int)$totalCount,
            "items_per_page" => $itemsPerPage,
            "total_pages" => $pages
        ];
        return [
            "data" => $result,
            "pagination" => $pagination
        ];
    }

    private function buildQuery($params)
    {
        $query = "SELECT phone FROM customer";
        if (isset($params['country_code']) || isset($params['valid'])) {
            $query .= " where ";
        }
        $countryCode = $params['country_code'];
        if (isset($params['country_code'])) {
            $query .= "phone like '($countryCode)%' ";
        }


        if (isset($params['country_code']) && isset($params['valid'])) {
            $query .= " and ";
            $countryRegex = CountriesEnum::COUNTRIES_CODES[$countryCode]['regex'];

            if ($params['valid'] == "true") {
                $query .= "phone REGEXP '$countryRegex' ";
            } else {
                $query .= "phone NOT REGEXP '$countryRegex' ";

            }
        }


        if (isset($params['valid']) && !isset($params['country_code'])) {
            $regex = CountriesEnum::getAllRegex(true);
            if ($params['valid'] == "true") {
                $query .= "phone REGEXP '$regex' ";
            } else {
                $query .= "phone NOT REGEXP '$regex' ";
            }
        }
        return $query;
    }

    private function getTotalCountForQuery($query)
    {
        $countQuery = str_replace('SELECT phone FROM', 'select  count(*) FROM', $query);

        return $this->connection->query($countQuery)->fetchColumn();

    }
}
