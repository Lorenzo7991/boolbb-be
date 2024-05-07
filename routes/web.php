 <?php

    use App\Http\Controllers\ApartmentController;
    use App\Http\Controllers\ImageController;
    use App\Http\Controllers\MessageController;
    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\SponsorshipController;
    use Illuminate\Support\Facades\Route;

    /*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

    Route::get('/', function () {
        return view('welcome');
    });

    Route::middleware('auth')->group(function () {
        Route::get('apartments/{apartment}/sponsorship', [SponsorshipController::class, 'create'])->name('sponsorship.create');
        Route::post('apartments/{apartment}/sponsorship', [SponsorshipController::class, 'store'])->name('sponsorship.store');

        //appartamenti sponsorizzati
        Route::get('apartments/sponsored', [ApartmentController::class, 'sponsored']);

        Route::patch('apartments/{apartment}/toggle-visibility', [ApartmentController::class, 'toggleVisibility'])->name('apartment.toggle-visibility');
        Route::resource('apartments', ApartmentController::class);
        Route::resource('messages', MessageController::class);
    });


    Route::post('apartments/{apartment}/images}', [ImageController::class, 'store'])->name('image.store');
    Route::delete('apartments/images/{image}', [ImageController::class, 'destroy'])->name('image.destroy');

    //rotta pagamenti


    Route::get('/admin', function () {
        return view('admin.home');
    })->middleware(['auth', 'verified'])->name('admin.home');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__ . '/auth.php';
