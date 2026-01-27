<?php

namespace App\Http\Controllers;

use App\Models\EmailTracking;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmailTrackingController extends Controller
{
    /**
     * Handle email open tracking
     */
    public function track(Request $request, string $trackingId)
    {
        // Find the tracking record
        $tracking = EmailTracking::where('tracking_id', $trackingId)->first();

        if (!$tracking) {
            // Return a 1x1 transparent pixel even if tracking ID is invalid
            return $this->getTrackingPixel();
        }

        // Record the open event
        $tracking->recordOpen(
            $request->userAgent(),
            $request->ip()
        );

        // Return a 1x1 transparent pixel
        return $this->getTrackingPixel();
    }

    /**
     * Get email tracking statistics
     */
    public function stats(Request $request)
    {
        $emailType = $request->query('type');

        $stats = EmailTracking::getStats($emailType);

        if ($request->wantsJson()) {
            return response()->json($stats);
        }

        return view('emails.stats', compact('stats', 'emailType'));
    }

    /**
     * Return a 1x1 transparent tracking pixel
     */
    private function getTrackingPixel(): Response
    {
        // Create a 1x1 transparent GIF pixel
        $pixel = base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');

        return response($pixel)
            ->header('Content-Type', 'image/gif')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}
