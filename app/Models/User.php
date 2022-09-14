<?php
/**
 * user eloquent model class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Carbon\Carbon;
use App\Support\Entity;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\Admin\ProfileValidation\DeniedProfileValidationNotification;
use App\Notifications\Admin\ProfileValidation\ApprovedProfileValidationNotification;
use App\Notifications\Index\Auth\EmailVerificationNotification;

class User extends Authenticatable
{
    use Notifiable,
        SoftDeletes;

    /**
     * model eloquent table name
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'type',
        'password',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * default attributes value
     *
     * @var array
     */
    protected $attributes =[
        'is_root'       => true,
        'is_active'     => false,
        'is_verified'   => false,
        'is_newsletter_subscriber' => false,
    ];

    /**
     * append values to attributes
     *
     * @var array
     */
    protected $appends = [
        'username',
        'last_update',
        'last_online'
    ];

    /**
     * casts attributes value
     *
     * @var array
     */
    protected $casts = [
        'is_root'       => 'bool',
        'is_active'     => 'bool',
        'is_verified'   => 'bool',
        'is_newsletter_subscriber' => 'bool',
    ];

    /**
     * date list of columns
     *
     * @var array
     */
    protected $dates = [
        'birthdate',
        self::CREATED_AT,
        'deleted_at',
        self::UPDATED_AT,
    ];

    /**
     * relation to user data model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userData() : Relations\HasMany
    {
        return $this->hasMany(UserData::class, 'user_id');
    }

    /**
     * relation to user location model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locations() : Relations\HasMany
    {
        return $this->hasMany(UserLocation::class, 'user_id');
    }

    /**
     * relation to user view model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function views() : Relations\HasMany
    {
        return $this->hasMany(UserView::class, 'user_id');
    }

    /**
     * Get total profile views
     * 
     * @return int
     */
    public function totalViews(): int
    {
        return $this->views()->selectRaw("COUNT(DISTINCT ip_address) AS total")->first()->total;
    }

    /**
     * relation to favorite view model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favorites() : Relations\HasMany
    {
        return $this->hasMany(Favorite::class, 'user_id');
    }

    /**
     * relation to favorite view model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favoriteEscorts() : Relations\HasMany
    {
        return $this->favorites()->where('object_type', Favorite::ESCORT_TYPE);
    }

    /**
     * relation to user descriptions model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function descriptions() : Relations\HasMany
    {
        return $this->hasMany(UserDescription::class, 'user_id');
    }

    /**
     * relation to user description model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function description() : Relations\HasOne
    {
        return $this->hasOne(UserDescription::class, 'user_id')->where('lang_code', app()->getLocale());;
    }

    /**
     * relation to user data model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function geoLocation() : Relations\HasOne
    {
        return $this->hasOne(UserGeoLocation::class, 'user_id');
    }

    /**
     * relation to tour plan model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tourPlans() : Relations\HasMany
    {
        return $this->hasMany(TourPlan::class, 'user_id')
            ->with(['continent', 'country', 'state', 'city']);
    }

    /**
     * relation to account deletion request model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function deletionRequest() : Relations\HasOne
    {
        return $this->hasOne(AccountDeletionRequest::class, 'user_id');
    }

    /**
     * relation to ban country model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function banCountries() : Relations\HasMany
    {
        return $this->hasMany(BanCountry::class, 'user_id');
    }

    /**
     * relation to user group model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userGroup() : Relations\BelongsTo
    {
        return $this->belongsTo(UserGroup::class, 'user_group_id');
    }

    /**
     * relation to user emails model (sender)
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function emails() : Relations\HasMany
    {
        return $this->hasMany(UserEmail::class, 'sender_user_id');
    }

    /**
     * relation to user emails model (recipient)
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipientEmails(): Relations\HasMany
    {
        return $this->hasMany(UserEmail::class, 'recipient_user_id');
    }

    /**
     * relation to photos model (primary)
     * @author Jhay Bagas <bagas.jhay@gmail.com>
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profilePicture() : Relations\HasOne
    {
        return $this->hasOne(Photo::class, 'user_id')
            ->where('is_primary', true);
    }

    /**
     * relation to review model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews() : Relations\HasMany
    {
        return $this->hasMany(UserReview::class, 'object_id');
    }

    /**
     * get total number of reviews
     *
     * @return int
     */
    public function getTotalReviews(): int
    {
        return $this->reviews()->count();
    }

    /**
     * relation to review model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sentReviews(): Relations\HasMany
    {
        return $this->hasMany(UserReview::class, 'user_id');
    }

    /**
     * get rating of reviews
     *
     * @return float|null
     */
    public function getRating() : ?float
    {
        return $this->reviews()
        ->where('is_approved', 1)
        ->groupBy('user_id')->select('rating', 'is_approved')->get() // @NOTE :: removed this if review is 1:1 or one user_id one review to object_id
        ->avg('rating');
    }
    
    /**
     * relation to escort follower model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function followers() : Relations\HasMany
    {
        return $this->hasMany(UserFollower::class, 'followed_user_id')->with(['follower']);
    }

    /**
     * relation to escort follower model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function followed() : Relations\HasMany
    {
        return $this->hasMany(UserFollower::class, 'follower_user_id');
    }

    /**
     * relation to escort booking model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings() : Relations\HasMany
    {
        return $this->hasMany(EscortBooking::class, 'user_id')->with('escort');
    }

    /**
     * relation to escort report model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reports() : Relations\HasMany
    {
        return $this->hasMany(EscortReport::class, 'escort_user_id')->with('escort');
    }

    /**
     * relation to user wallet model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function wallet() : Relations\HasOne
    {
        return $this->hasOne(Wallet::class, 'user_id');
    }

    /**
     * password attribute set mutator
     *
     * @param  string $password
     *
     * @return void
     */
    public function setPasswordAttribute($plain) : void
    {
        $this->attributes['password'] = app('hash')->make($plain);
        $this->original['password']   = $plain;
    }

    /**
     * username attribute get mutator
     *
     * @return string
     */
    public function getUsernameAttribute() : string
    {
        if (isset($this->attributes['username'])) {
            return $this->attributes['username'];
        }

        return $this->getUsernameFromEmail();
    }

    /**
     * username attribute set mutator
     *
     * @param  string $username
     *
     * @return void
     */
    public function setUsernameAttribute($username)
    {
        if (empty($username)) {
            $username = $this->getUsernameFromEmail();
        }

        $this->attributes['username'] = $username;
        //$this->original['username']   = $username; // removed this to save username
    }

    /**
     * userData get attribute mutator
     *
     * @return App\Support\Entity\UserData
     */
    public function getUserDataAttribute()
    {
        $data = $this->userData()->get();
        $entity = new Entity\UserData(['user' => $this]);

        foreach ($data as $model) {
            $entity->populate([
                $model->field => $model->content
            ]);
        }

        return $entity;
    }

    /**
     * age attribute get muttator
     *
     * @return int|null
     */
    public function getAgeAttribute()
    {
        if (! $this->birthdate) {
            return;
        }

        return Carbon::parse($this->birthdate)->age;
    }

    /**
     * checks if user is active
     *
     * @return boolean
     */
    public function isActive() : bool
    {
        return $this->getAttribute('is_active');
    }

    /**
     * check if user account is approved
     *
     * @return boolean
     */
    public function isApproved() : bool
    {
        return $this->getAttribute('is_approved');
    }

    /**
     * check if user is already verified
     *
     * @return boolean
     */
    public function isVerified() : bool
    {
        return $this->getAttribute('is_verified');
    }

    /**
     * check if user is blocked
     *
     * @return boolean
     */
    public function isBlocked() : bool
    {
        return $this->getAttribute('is_blocked');
    }

    /**
     * checks if user is newsletter subscriber
     *
     * @return boolean
     */
    public function isNewsletterSubscriber() : bool
    {
        return $this->getAttribute('is_newsletter_subscriber');
    }

    /**
     * get type
     *
     * @return string
     */
    public function getType() : string
    {
        return ($this->type) ?: static::USER_TYPE;
    }

    /**
     * extracts username from email
     *
     * @return string
     */
    protected function getUsernameFromEmail() : string
    {
        return (isset($this->attributes['email'])) ? explode('@', $this->attributes['email'])[0] : '';
    }

    /**
     * birthdate attribute set mutator
     *
     * @param  string $username
     *
     * @return void
     */
    public function setBirthdateAttribute($birthdate)
    {
        if (!empty($birthdate)) {
            $this->attributes['birthdate'] = Carbon::parse($birthdate)->format('Y-m-d');
        }
    }

    /**
     * birthdate attribute get mutator
     *
     * @return mixed
     */
    public function getBirthdateAttribute()
    {
        if (isset($this->attributes['birthdate']) && !empty($this->attributes['birthdate'])) {
            return Carbon::parse($this->attributes['birthdate'])->format('m/d/Y');
        }
        return false;
    }

    /**
     * accessor for profile_photo attribute
     *
     * @return App\Models\Photo|null
     */
    public function getProfilePhotoAttribute() : ?Photo
    {
        return $this->profilePicture;
    }

    /**
     * Retrieves the user's primary picture from the uploaded images
     * @author Jhay Bagas <bagas.jhay@gmail.com>
     *
     * @return string|null
     */
    public function getProfileImage() : ?string
    {
        $data = $this->profilePicture()->first();

        if ($data) {
            return $data->path;
        }

        return null;
    }

    /**
     * accessor for profile_photo_url attribute
     *
     * @return string|null
     */
    public function getProfilePhotoUrlAttribute() : ?string
    {
        $photo = $this->profilePhoto;

        if (is_null($photo)) {
            return null;
        }

        return route(
            'common.photo',
            [
                'path' => $photo->path,
                'photo' => $photo->getKey(),
            ]
        );
    }

    /**
     * sends notification for this user that profile validation has been denied
     *
     * @param string $reason
     *
     * @return void
     */
    public function sendDeniedProfileValidationNotification(string $reason) : void
    {
        $this->notify(new DeniedProfileValidationNotification($reason));
    }

    /**
     * sends notification for this user that profile validation has been approved
     *
     * @return void
     */
    public function sendApprovedProfileValidationNotification() : void
    {
        $this->notify(new ApprovedProfileValidationNotification);
    }

    /**
     * get the last update of user
     *
     * @return string
     */
    public function getLastUpdateAttribute() : string
    {
        if (isset($this->attributes['updated_at']) && !empty($this->attributes['updated_at'])) {
            return Carbon::parse($this->attributes['updated_at'])->format('m/d/Y');
        }
        return '';
    }

    /**
     * get the last online of user
     *
     * @return string
     */
    public function getLastOnlineAttribute() : string
    {
        if (isset($this->attributes['last_login_at']) && !empty($this->attributes['updated_at'])) {
            return Carbon::parse($this->attributes['last_login_at'])->format('m/d/Y - H:i');
        }
        return '';
    }

    /**
     * send an change email notification
     *
     * @param  string $token
     *
     * @return void
     */
    public function sendEmailForVerificationNotification($token): void
    {
        $this->notify(new EmailVerificationNotification($token));
    }

    /**
     * check if users email is verified
     *
     * @return bool
     */
    public function isEmailVerified()
    {
        return !empty($this->getAttribute('email_verified_at'));
    }

    /**
     * relation to photo model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos(): Relations\HasMany
    {
        return $this->hasMany(Photo::class, 'user_id');
    }

    /**
     * get total photos
     *
     * @return int
     */
    public function getTotalPhotos(): int
    {
        return $this->photos->count();
    }

    /**
     * get total new photos
     *
     * @return int
     */
    public function getTotalNewPhotos(): int
    {
        return $this->photos()->whereDate(Photo::CREATED_AT, Carbon::today())->count();
    }

    /**
     * relation to video model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos(): Relations\HasMany
    {
        return $this->hasMany(UserVideo::class, 'user_id');
    }

    /**
     * get total videos
     *
     * @return int
     */
    public function getTotalVideos(): int
    {
        return $this->videos->count();
    }

    /**
     * get total new videos
     *
     * @return int
     */
    public function getTotalNewVideos(): int
    {
        return $this->videos()->whereDate(UserVideo::CREATED_AT, Carbon::today())->count();
    }
}
