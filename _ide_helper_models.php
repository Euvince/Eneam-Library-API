<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $type
 * @property string $title
 * @property string $slug
 * @property string $summary
 * @property string $author
 * @property string $editor
 * @property string $editing_year
 * @property string $cote
 * @property int $number_pages
 * @property string $ISBN
 * @property int $available_stock
 * @property int $available
 * @property int $loaned
 * @property int $reserved
 * @property int $has_ebook
 * @property int $has_podcast
 * @property array|null $keywords
 * @property array|null $formats
 * @property array|null $access_paths
 * @property int $likes_number
 * @property int $views_number
 * @property int $stars_number
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $year_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Loan> $loans
 * @property-read int|null $loans_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reservation> $reservations
 * @property-read int|null $reservations_count
 * @property-read \App\Models\SchoolYear|null $schoolYear
 * @method static \Database\Factories\ArticleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereAccessPaths($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereAvailableStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereEditingYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereEditor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereFormats($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereHasEbook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereHasPodcast($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereISBN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereLikesNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereLoaned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereNumberPages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereReserved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereStarsNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereViewsNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereYearId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Article withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperArticle {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $content
 * @property int $likes_number
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $article_id
 * @property int|null $user_id
 * @property-read \App\Models\Article|null $article
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\CommentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereLikesNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperComment {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $school_name
 * @property string $school_acronym
 * @property string $school_city
 * @property string $archivist_full_name
 * @property float $eneamien_subscribe_amount
 * @property float $extern_subscribe_amount
 * @property int $subscription_expiration_delay
 * @property float $student_debt_amount
 * @property float $teacher_debt_amount
 * @property int $student_loan_delay
 * @property int $teacher_loan_delay
 * @property int $student_renewals_number
 * @property int $teacher_renewals_number
 * @property int $max_books_per_student
 * @property int $max_books_per_teacher
 * @property int $max_copies_books_per_student
 * @property int $max_copies_books_per_teacher
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $year_id
 * @property-read \App\Models\SchoolYear|null $schoolYear
 * @method static \Database\Factories\ConfigurationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration query()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereArchivistFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereEneamienSubscribeAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereExternSubscribeAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereMaxBooksPerStudent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereMaxBooksPerTeacher($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereMaxCopiesBooksPerStudent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereMaxCopiesBooksPerTeacher($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereSchoolAcronym($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereSchoolCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereSchoolName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereStudentDebtAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereStudentLoanDelay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereStudentRenewalsNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereSubscriptionExpirationDelay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereTeacherDebtAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereTeacherLoanDelay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereTeacherRenewalsNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereYearId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperConfiguration {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $code
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Soutenance> $soutenances
 * @property-read int|null $soutenances_count
 * @method static \Database\Factories\CycleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCycle {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $observation
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $supported_memory_id
 * @property-read \App\Models\SupportedMemory|null $supportedMemory
 * @method static \Database\Factories\FilingReportFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|FilingReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FilingReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FilingReport onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FilingReport query()
 * @method static \Illuminate\Database\Eloquent\Builder|FilingReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilingReport whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilingReport whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilingReport whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilingReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilingReport whereObservation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilingReport whereSupportedMemoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilingReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilingReport whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilingReport withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FilingReport withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperFilingReport {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\KeywordFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword query()
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperKeyword {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $loan_date
 * @property string|null $processing_date
 * @property int $duration
 * @property string $status
 * @property int $renewals
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Article> $articles
 * @property-read int|null $articles_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\LoanFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Loan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Loan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Loan onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Loan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereLoanDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereProcessingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereRenewals($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Loan withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperLoan {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property float $amount
 * @property string $payment_date
 * @property string $status
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $user_id
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\PaymentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPayment {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $guard_name
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RoleType> $rolesTypes
 * @property-read int|null $roles_types_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\PermissionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission withoutRole($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPermission {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $reservation_date
 * @property string $processing_date
 * @property string $start_date
 * @property string $end_date
 * @property string $status
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Article> $articles
 * @property-read int|null $articles_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\ReservationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereProcessingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereReservationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperReservation {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $guard_name
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $role_type_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Models\RoleType|null $roleType
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\RoleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Role permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereRoleTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Role withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Role withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperRole {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\RoleTypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|RoleType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleType query()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleType whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleType whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleType whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleType withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleType withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperRoleType {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $start_date
 * @property string $end_date
 * @property string $school_year
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Article> $articles
 * @property-read int|null $articles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Configuration> $configurations
 * @property-read int|null $configurations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Soutenance> $soutenances
 * @property-read int|null $soutenances_count
 * @method static \Database\Factories\SchoolYearFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|SchoolYear newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SchoolYear newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SchoolYear onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SchoolYear query()
 * @method static \Illuminate\Database\Eloquent\Builder|SchoolYear whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchoolYear whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchoolYear whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchoolYear whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchoolYear whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchoolYear whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchoolYear whereSchoolYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchoolYear whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchoolYear whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchoolYear whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchoolYear withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SchoolYear withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperSchoolYear {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $type
 * @property string $name
 * @property string $slug
 * @property string $acronym
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $sector_id
 * @property-read Sector|null $sector
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Sector> $specialities
 * @property-read int|null $specialities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SupportedMemory> $supportedMemories
 * @property-read int|null $supported_memories_count
 * @method static \Database\Factories\SectorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Sector newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sector newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sector onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Sector query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sector whereAcronym($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sector whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sector whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sector whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sector whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sector whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sector whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sector whereSectorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sector whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sector whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sector whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sector whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sector withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Sector withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperSector {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $slug
 * @property string $start_date
 * @property string $end_date
 * @property int $number_memories_expected
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $cycle_id
 * @property int|null $year_id
 * @property-read \App\Models\Cycle|null $cycle
 * @property-read \App\Models\SchoolYear|null $schoolYear
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SupportedMemory> $supportedMemories
 * @property-read int|null $supported_memories_count
 * @method static \Database\Factories\SoutenanceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Soutenance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Soutenance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Soutenance onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Soutenance query()
 * @method static \Illuminate\Database\Eloquent\Builder|Soutenance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Soutenance whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Soutenance whereCycleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Soutenance whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Soutenance whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Soutenance whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Soutenance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Soutenance whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Soutenance whereNumberMemoriesExpected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Soutenance whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Soutenance whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Soutenance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Soutenance whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Soutenance whereYearId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Soutenance withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Soutenance withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperSoutenance {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property float $amount
 * @property string $status
 * @property string $subscription_date
 * @property string $expiration_date
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $user_id
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\SubscriptionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereExpirationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereSubscriptionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperSubscription {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $theme
 * @property string $slug
 * @property string $start_at
 * @property string $ends_at
 * @property string $first_author_matricule
 * @property string $second_author_matricule
 * @property string $first_author_firstname
 * @property string $second_author_firstname
 * @property string $first_author_lastname
 * @property string $second_author_lastname
 * @property string $first_author_email
 * @property string $second_author_email
 * @property string $first_author_phone
 * @property string $second_author_phone
 * @property string $jury_president_name
 * @property string $memory_master_name
 * @property string|null $memory_master_email
 * @property string|null $cote
 * @property string $status
 * @property string|null $file_path
 * @property string|null $cover_page_path
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $sector_id
 * @property int|null $soutenance_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FilingReport> $finlingReports
 * @property-read int|null $finling_reports_count
 * @property-read \App\Models\Sector|null $sector
 * @property-read \App\Models\Soutenance|null $soutenance
 * @method static \Database\Factories\SupportedMemoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory query()
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereCote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereCoverPagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereFirstAuthorEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereFirstAuthorFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereFirstAuthorLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereFirstAuthorMatricule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereFirstAuthorPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereJuryPresidentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereMemoryMasterEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereMemoryMasterName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereSecondAuthorEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereSecondAuthorFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereSecondAuthorLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereSecondAuthorMatricule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereSecondAuthorPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereSectorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereSoutenanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereTheme($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SupportedMemory withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperSupportedMemory {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $matricule
 * @property string $firstname
 * @property string $lastname
 * @property string $slug
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property string $phone_number
 * @property string $birth_date
 * @property string $sex
 * @property string|null $profile_photo_path
 * @property int $has_paid
 * @property int $has_access
 * @property float $debt_amount
 * @property string|null $remember_token
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Loan> $loans
 * @property-read int|null $loans_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reservation> $reservations
 * @property-read int|null $reservations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Subscription> $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDebtAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereHasAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereHasPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMatricule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutRole($roles, $guard = null)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

