<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'city' => ['nullable', 'string', 'max:100'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
        ]);

        $selectedCity = null;

        if (!empty($validated['city'])) {
            $selectedCity = $validated['city'];
            session(['selected_city' => $selectedCity]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'city' => $selectedCity,
                    'message' => 'Location updated successfully.',
                ]);
            }

            return back()->with('success', 'Location updated successfully.');
        }

        if ($request->filled('latitude') && $request->filled('longitude')) {
            $selectedCity = $this->resolveCityFromCoordinates((float) $validated['latitude'], (float) $validated['longitude']);
            session(['selected_city' => $selectedCity]);
            session(['gps_coordinates' => [
                'latitude' => (float) $validated['latitude'],
                'longitude' => (float) $validated['longitude'],
            ]]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'city' => $selectedCity,
                    'message' => 'Location updated successfully.',
                ]);
            }

            return back()->with('success', 'Location updated successfully.');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'No city or GPS coordinates were provided.',
            ], 422);
        }

        return back()->with('success', 'Location updated successfully.');
    }

    private function resolveCityFromCoordinates(float $latitude, float $longitude): string
    {
        $cities = [
            'Karachi' => ['latitude' => 24.8607, 'longitude' => 67.0011],
            'Lahore' => ['latitude' => 31.5204, 'longitude' => 74.3587],
            'Islamabad' => ['latitude' => 33.6844, 'longitude' => 73.0479],
        ];

        $closestCity = 'Karachi';
        $closestDistance = PHP_FLOAT_MAX;

        foreach ($cities as $city => $coordinates) {
            $distance = sqrt(
                pow($latitude - $coordinates['latitude'], 2) +
                pow($longitude - $coordinates['longitude'], 2)
            );

            if ($distance < $closestDistance) {
                $closestDistance = $distance;
                $closestCity = $city;
            }
        }

        return $closestCity;
    }
}