<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Call>
 */
class UserCallingDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        $randomNumber = function ($length) {
            $result = '';

            for ($i = 0; $i < $length; $i++) {
                $result .= random_int(0, 9);
            }

            return $result;
        };
        $mobileNumber = '+917671231833';
        $mobileNumberUnique = substr($mobileNumber, 0, -4) . $randomNumber(4);

        return [
            'user_id' => User::factory(),
            'calling_mobile' => $mobileNumberUnique,
            'created_at' => $this->faker->dateTimeBetween('-6 days', now()),
            'contact_list_name' => $this->faker->sentence(8),
            'incoming_message' => 'Sir, I am calling from HDFC',
            'alert_sent' => 'Not Interested',
            'kb_id' => $this->faker->sentence(8),
        ];
    }
}
