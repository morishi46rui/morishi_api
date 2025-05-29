<?php

declare(strict_types=1);

namespace App\UseCases\Scraping;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

final class ScrapePageAction
{
    public function __invoke(string $url): array
    {
        $client = new Client();
        $response = $client->request('GET', $url);
        $html = (string) $response->getBody();
        $crawler = new Crawler($html);

        return [
            'url' => $url,
            'results' => $this->scrapeResults($crawler),
            'corners' => $this->scrapeCorners($crawler),
            'refunds' => $this->scrapeRefunds($crawler),
            'lap_time' => $this->scrapeLapTime($crawler),
        ];
    }

    private function scrapeResults(Crawler $crawler): array
    {
        $rows = $crawler->filter('#All_Result_Table tbody tr');
        $results = [];

        foreach ($rows as $row) {
            $tds = (new Crawler($row))->filter('td');
            if ($tds->count() < 15) {
                continue;
            }

            $results[] = [
                'rank'         => trim($tds->eq(0)->text()),
                'waku'         => trim($tds->eq(1)->text()),
                'number'       => trim($tds->eq(2)->text()),
                'name'         => trim($tds->eq(3)->filter('a')->text()),
                'sex_age'      => trim($tds->eq(4)->text()),
                'weight'       => trim($tds->eq(5)->text()),
                'jockey'       => trim($tds->eq(6)->text()),
                'time'         => trim($tds->eq(7)->text()),
                'margin'       => trim($tds->eq(8)->text()),
                'popularity'   => trim($tds->eq(9)->text()),
                'odds'         => trim($tds->eq(10)->text()),
                'last3f'       => trim($tds->eq(11)->text()),
                'corner'       => trim($tds->eq(12)->text()),
                'trainer'      => trim($tds->eq(13)->text()),
                'horse_weight' => trim($tds->eq(14)->text()),
            ];
        }

        return $results;
    }

    private function scrapeCorners(Crawler $crawler): array
    {
        $table = $crawler->filter('table.Corner_Num');
        $corners = [];

        $table->filter('tr')->each(function (Crawler $tr) use (&$corners) {
            $cornerName = trim($tr->filter('th')->text());
            $order = trim($tr->filter('td')->text());
            $corners[] = [
                'corner' => $cornerName,
                'order' => $order,
            ];
        });

        return $corners;
    }

    private function scrapeRefunds(Crawler $crawler): array
    {
        $refunds = [];

        $crawler->filter('.Payout_Detail_Table')->each(function (Crawler $table) use (&$refunds) {
            $rows = $table->filter('tr');

            foreach ($rows as $row) {
                $rowCrawler = new Crawler($row);
                $type = trim($rowCrawler->filter('th')->text());

                $result = $rowCrawler->filter('td')->eq(0)->text(null, false);
                $payout = $rowCrawler->filter('td')->eq(1)->text(null, false);
                $popularity = $rowCrawler->filter('td')->eq(2)->text(null, false);

                $refunds[] = [
                    'type' => $type,
                    'result' => trim(preg_replace('/\s+/', ' ', $result)),
                    'payout' => trim(preg_replace('/\s+/', ' ', $payout)),
                    'popularity' => trim(preg_replace('/\s+/', ' ', $popularity)),
                ];
            }
        });

        return $refunds;
    }

    private function scrapeLapTime(Crawler $crawler): array
    {
        $labels = [];
        $cumulative = [];
        $each = [];

        $table = $crawler->filter('.Race_HaronTime');

        $table->filter('tr')->each(function (Crawler $tr, int $i) use (&$labels, &$cumulative, &$each) {
            $cells = $tr->filter('th, td');
            if ($cells->count() === 0) return;

            $values = $cells->each(fn(Crawler $cell) => trim($cell->text()));

            match ($i) {
                0 => $labels = $values,
                1 => $cumulative = $values,
                2 => $each = $values,
                default => null
            };
        });

        return [
            'labels' => $labels,
            'cumulative' => $cumulative,
            'each' => $each,
        ];
    }
}
