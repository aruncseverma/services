<?php
/**
 * controller class for updating escort schedules
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Services;

use App\Models\Escort;
use Illuminate\Http\Request;
use App\Models\EscortSchedule;
use Illuminate\Http\RedirectResponse;
use App\Repository\EscortScheduleRepository;

class UpdateSchedulesController extends Controller
{
    /**
     * escort schedule repository instance
     *
     * @var App\Repository\EscortScheduleRepository
     */
    protected $repository;

    /**
     * create instance
     *
     * @param App\Repository\EscortScheduleRepository $repository
     */
    public function __construct(EscortScheduleRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    /**
     * handles incoming request
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request) : RedirectResponse
    {
        $this->validateRequest($request);

        $escort = $this->getAuthUser();

        // save schedules defined
        $this->saveSchedule($request->input('schedules', []), $escort);

        $this->notifySuccess(__('Schedule saved successfully'));

        return back()->withInput(['notify' => 'schedules']);
    }

    /**
     * validate request data
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function validateRequest(Request $request) : void
    {
        $this->validate(
            $request,
            [
                'schedules' => [
                    'required',
                    'array',
                ],
                'schedules.*.from' => [
                    'date_format:' . EscortSchedule::TIME_FORMAT,
                ],
                'schedules.*.till' => [
                    'date_format:' . EscortSchedule::TIME_FORMAT,
                ],
            ]
        );
    }

    /**
     * saves schedule requested by the escort
     *
     * @param  array             $schedules
     * @param  App\Models\Escort $escort
     *
     * @return void
     */
    protected function saveSchedule(array $schedules, Escort $escort) : void
    {
        foreach (EscortSchedule::ALLOWED_SCHEDULES as $day) {
            $schedule = $this->repository->getScheduleFromEscortByDay($day, $escort);

            if (array_key_exists($day, $schedules)) {
                $from = (isset($schedules[$day]['from'])) ? $schedules[$day]['from'] : null;
                $till = (isset($schedules[$day]['till'])) ? $schedules[$day]['till'] : null;

                // store schedule
                $this->repository->store(['from' => $from, 'till' => $till, 'day' => $day], $escort, $schedule);
            }
        }
    }
}
