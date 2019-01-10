<?php

declare(strict_types = 1);

namespace Drupal\oe_theme\ValueObject;

use Drupal\Component\Datetime\DateTimePlus;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Handle information about a date.
 */
class DateValueObject extends ValueObjectBase implements DateValueObjectInterface {

  /**
   * The day property.
   *
   * @var string
   */
  private $day;

  /**
   * The month property.
   *
   * @var string
   */
  private $month;

  /**
   * The year property.
   *
   * @var string
   */
  private $year;

  /**
   * The weekDay property.
   *
   * @var string
   */
  private $weekDay;

  /**
   * The month name property.
   *
   * @var string
   */
  private $monthName;

  /**
   * DateValueObject constructor.
   *
   * @param string $day
   *   The date day.
   * @param string $month
   *   The date month.
   * @param string $year
   *   The date year.
   * @param string|int|null $weekDay
   *   The day of the week.
   */
  private function __construct(string $day, string $month, string $year, string $weekDay = NULL) {
    $this->day = $day;
    $this->month = $month;
    $this->year = $year;
    $this->weekDay = $weekDay;

    $date = new DateTimePlus(implode('-', [$year, $month, $day]));

    $this->weekDay = empty($weekDay) ?
      $date->format('l') :
      $weekDay;
    $this->monthName = $date->format('F');
  }

  /**
   * {@inheritdoc}
   */
  public static function fromTimestamp(int $timestamp, string $timezone = null): DateValueObjectInterface {
    $dt = new \DateTime();
    $dt->setTimestamp($timestamp);

    if ($timezone !== null) {
      $dt->setTimezone(new \DateTimeZone());
    }

    return new static(...explode(
        '-',
        $dt->format('d-m-Y')
      )
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function fromArray(array $parameters = []): ValueObjectInterface {
    return new static(
      $parameters['day'],
      $parameters['month'],
      $parameters['year']
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getArray(): array {
    return [
      'day' => $this->day,
      'month' => $this->month,
      'year' => $this->year,
      'week_day' => $this->weekDay,
      'monthname' => $this->monthName,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getDay(): string {
    return $this->day;
  }

  /**
   * {@inheritdoc}
   */
  public function getMonth(): string {
    return $this->month;
  }

  /**
   * {@inheritdoc}
   */
  public function getYear(): string {
    return $this->year;
  }

  /**
   * {@inheritdoc}
   */
  public function getWeekDay(): string {
    return $this->weekDay;
  }

  /**
   * {@inheritdoc}
   */
  public function getMonthName(): string {
    return $this->monthName;
  }

}
