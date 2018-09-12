<?
namespace App\Service;

class InfiniteScrollService
{
    public function setPaginationNext($pagination, $request)
    {
        if ($pagination->getPage() < $pagination->getPageCount()) {
            $url_query = $request->query->all();
            $url_query['page'] = ($url_query['page'] ?? 1) + 1;
            $pagination->pagination_next = $request->getPathInfo().'?'.http_build_query($url_query);
        }
        else {
            $pagination->pagination_next = '';
        }

        return $pagination;
    }
}