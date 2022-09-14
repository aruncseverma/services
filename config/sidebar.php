<?php
/**
 * config repository for sidebar
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

return [
  'admin' => [
    'dashboard' => [
      'text' => 'Dashboard',
      'route' => 'admin.dashboard',
      'icon' => 'mdi mdi-gauge'
    ],
    'escorts' => [
      'text'  => 'Escorts',
      'icon'  => 'mdi mdi-account-multiple',
      'badge' => 'escorts',
      'children' => [
        'manage' => [
          'text' => 'Manage Escorts',
          'route' => 'admin.escorts.manage',
          'permissions' => 'escorts.manage',
        ],
        'manage_pending' => [
          'text' => 'Pending For Approval',
          'route' => 'admin.escorts.manage_pending',
          'permissions' => 'escorts.manage',
        ],
        'manage_accounts_deleted' => [
          'text' => 'Account Closed By Members',
          'route' => 'admin.escorts.accounts_deleted',
          'permissions' => 'escorts.manage',
        ],
        'new' => [
          'text' => 'New Escort',
          'route' => 'admin.escort.create',
          'permissions' => 'escorts.create',
        ],
        'manage_profile_validations' => [
          'text' => 'Profile Validations',
          'route' => 'admin.profile_validation.manage',
        ],
      ]
    ],
    'agency' => [
      'text'  => 'Agency',
      'icon'  => 'mdi mdi-account-multiple',
      'children' => [
        'manage' => [
          'text' => 'Manage Agency',
          'route' => 'admin.agency.manage',
          'permissions' => 'agency.manage',
        ],
        'manage_pending_agency' => [
          'text' => 'Pending For Approval',
          'route' => 'admin.agency.manage_pending',
          'permissions' => 'agency.manage',
          'badge' => 'new_agency'
        ],
        'new' => [
          'text' => 'New Agency',
          'route' => 'admin.agency.create',
          'permissions' => 'agency.create',
        ]
      ]
    ],
    'member' => [
      'text'  => 'Members',
      'icon'  => 'mdi mdi-account-multiple',
      'children' => [
        'manage' => [
          'text' => 'Manage Members',
          'route' => 'admin.members.manage',
          'permissions' => 'members.manage',
        ],
        'new' => [
          'text' => 'New Member',
          'route' => 'admin.member.create',
          'permissions' => 'members.create',
        ],
      ]
    ],
    'administrator' => [
      'text'  => 'Administrators',
      'icon'  => 'mdi mdi-account-multiple',
      'children' => [
        'manage' => [
          'text' => 'Manage Administrators',
          'route' => 'admin.administrators.manage',
          'permissions' => 'administrators.manage',
        ],
        'new' => [
          'text' => 'New Administrator',
          'route' => 'admin.administrator.create',
          'permissions' => 'administrators.create',
        ],
        'roles' => [
          'text' => 'Roles and Permissions',
          'route' => 'admin.permissions.manage',
          'permissions' => 'roles.manage',
        ],
      ]
    ],
    'services' => [
      'text' => 'Escort Services',
      'icon' => 'mdi mdi-cash',
      'children' => [
        'categories' => [
          'text' => 'Categories',
          'icon' => 'mdi mdi-format-list-bulleted',
          'children' => [
            'manage' => [
              'text' => 'Manage Categories',
              'route' => 'admin.services.categories.manage',
            ],
            'create' => [
              'text' => 'Create Category',
              'route' => 'admin.services.categories.create',
            ],
          ],
        ],
        'manage' => [
          'text' => 'Manage Services',
          'route' => 'admin.services.manage'
        ],
        'create' => [
          'text' => 'Create Service',
          'route' => 'admin.service.create'
        ],
      ],
    ],
    'attributes' => [
      'text' => 'Attributes',
      'icon' => 'mdi mdi-format-list-bulleted',
      'children' => [
        'common_physical' => [
          'text'  => 'Common Physical Attributes',
          'route' => [
            'admin.attributes.physical.manage',
            [
              'name' => App\Models\Attribute::ATTRIBUTE_HAIR_COLOR
            ]
          ]
        ],
        'languages' => [
          'text'  => 'Languages',
          'route' => 'admin.attributes.languages.manage',
        ]
      ]
    ],
    'rates' => [
      'text' => 'Rates',
      'icon' => 'mdi mdi-clock',
      'children' => [
        'manage_durations' => [
          'text' => 'Manage Rate Durations',
          'route' => 'admin.rate_durations.manage',
        ],
        'new_duration' => [
          'text' => 'New Rate Duration',
          'route' => 'admin.rate_duration.create'
        ],
      ],
    ],
    'languages' => [
      'text' => 'Languages',
      'icon' => 'mdi mdi-web',
      'children' => [
        'manage' => [
          'text' => 'Manage Languages',
          'route' => 'admin.languages.manage',
        ],
        'new' => [
          'text' => 'New Language',
          'route' => 'admin.language.create'
        ]
      ]
    ],
    'locations' => [
      'text' => 'Locations',
      'icon' => 'mdi mdi-map-marker',
      'route' => 'admin.locations.manage',
    ],
    'Finance' => [
      'text' => 'Finance',
      'icon' => 'mdi mdi-square-inc-cash',
      'children' => [
        'transactions' => [
          'text' => 'Transactions',
          'route' => 'admin.finance.transactions',
          'permissions' => 'general_settings.manage',
        ],
        'billers' => [
          'text' => 'Billers',
          'route' => 'admin.finance.billers',
          'permissions' => 'general_settings.manage',
        ],
        'packages' => [
          'text' => 'Packages',
          'route' => 'admin.finance.packages',
          'permissions' => 'general_settings.manage',
        ],
        'plans' => [
          'text' => 'Membership Plans',
          'route' => 'admin.finance.plans',
          'permission' => 'general_settings.manage'
        ],
        'purchases' => [
          'text' => 'Vip Transactions',
          'route' => 'admin.finance.vip.transaction',
          'permission' => 'general_settings.manage',
          'badge' => 'purchases'
        ]
      ]
    ],
    'post' => [
      'text'  => 'Posts',
      'icon'  => 'mdi mdi-blogger',
      'children' => [
        'categories' => [
          'text' => 'Categories',
          'icon' => 'mdi mdi-format-list-bulleted',
          'children' => [
            'manage' => [
              'text' => 'Manage Categories',
              'route' => 'admin.posts.categories.manage',
              'permissions' => 'posts.manage',
            ],
            'create' => [
              'text' => 'Create Category',
              'route' => 'admin.posts.categories.create',
              'permissions' => 'posts.manage',
            ],
          ],
        ],
        'tags' => [
          'text' => 'Tags',
          'icon' => 'mdi mdi-format-list-bulleted',
          'children' => [
            'manage' => [
              'text' => 'Manage Tags',
              'route' => 'admin.posts.tags.manage',
              'permissions' => 'posts.manage',
            ],
            'create' => [
              'text' => 'Create Tag',
              'route' => 'admin.posts.tags.create',
              'permissions' => 'posts.manage',
            ],
          ],
        ],
        'manage' => [
          'text' => 'Manage Posts',
          'route' => 'admin.posts.manage',
          'permissions' => 'posts.manage',
        ],
        'new' => [
          'text' => 'New Post',
          'route' => 'admin.post.create',
          'permissions' => 'posts.create',
        ],
      ]
    ],
    'page' => [
      'text'  => 'Pages',
      'icon'  => 'mdi mdi-file-powerpoint-box',
      'children' => [
        'manage' => [
          'text' => 'Manage Pages',
          'route' => 'admin.pages.manage',
          'permissions' => 'pages.manage',
        ],
        'new' => [
          'text' => 'New Page',
          'route' => 'admin.page.create',
          'permissions' => 'pages.create',
        ],
      ]
    ],
    'translation' => [
      'text'  => 'Translations',
      'icon'  => 'mdi mdi-translate',
      'children' => [
        'manage' => [
          'text' => 'Manage Translations',
          'route' => 'admin.translations.manage',
        ],
        'new' => [
          'text' => 'New Translation',
          'route' => 'admin.translation.create',
        ],
      ]
    ],
    'general_settings' => [
        'text' => 'General Settings',
        'icon' => 'mdi mdi-settings',
        'children' => [
            'site' => [
                'text' => 'Site Settings',
                'route' => 'admin.settings.site',
                'permissions' => 'general_settings.manage',
            ],
            'mail' => [
                'text' => 'Mail Settings',
                'route' => 'admin.settings.mail',
                'permissions' => 'general_settings.manage',
            ],
            'image' => [
                'text' => 'Image Settings',
                'route' => 'admin.settings.image',
                'permissions' => 'general_settings.manage',
            ],
            'video' => [
                'text' => 'Video Settings',
                'route' => 'admin.settings.video',
                'permissions' => 'general_settings.manage',
            ]
        ]
    ]
  ],
  'escort_admin' => [
    'dashboard' => [
      'text' => 'Dashboard',
      'icon' => 'mdi mdi-gauge',
      'route' => 'escort_admin.dashboard',
    ],
    'escort_profile' => [
      'text'  => 'Escort Profile',
      'icon'  => 'mdi mdi-account-multiple',
      'route' => 'escort_admin.profile',
    ],
    'rates_services' => [
      'text' => 'Rates, Schedules & Services',
      'icon' => 'mdi mdi-cash',
      'route' => 'escort_admin.rates_services',
    ],
    'bookings' => [
      'text' => 'Bookings',
      'icon' => 'mdi mdi-calendar',
      'route' => 'escort_admin.bookings',
    ],
    'reviews' => [
      'text'  => 'Reviews',
      'icon'  => 'mdi mdi-format-quote',
      'route' => 'escort_admin.reviews',
    ],
    'photos' => [
      'text' => 'Photos',
      'icon' => 'mdi mdi-image',
      'route' => 'escort_admin.photos'
    ],
    'videos' => [
      'text' => 'Videos',
      'icon' => 'mdi mdi-video',
      'route' => 'escort_admin.videos'
    ],
    'profile_validation' => [
      'text' => 'Private Profile & Validation',
      'icon' => 'mdi mdi-account',
      'route' => 'escort_admin.profile_validation',
    ],
    'followers' => [
      'text'  => 'Followers',
      'icon'  => 'mdi mdi-account-multiple-outline',
      'route' => 'escort_admin.followers',
    ],
    'tour_plans' => [
      'text' => 'Set Tour Plan',
      'icon' => 'mdi mdi-airplane-landing',
      'route' => 'escort_admin.tour_plans',
    ],
    'email' => [
      'text' => 'Email',
      'icon' => 'mdi mdi-email',
      'route' => 'escort_admin.emails.manage'
    ],
    'account_settings' => [
      'text' => 'Account Settings',
      'icon' => 'mdi mdi-settings',
      'route' => 'escort_admin.account_settings'
    ],
    'logout' => [
      'text' => 'Logout',
      'icon' => 'mdi mdi-logout',
      'route' => 'escort_admin.auth.logout',
    ],
  ],
  'agency_admin' => [
    'dashboard' => [
    'text' => 'Dashboard',
    'icon' => 'mdi mdi-gauge',
    'route' => 'agency_admin.dashboard',
    ],
    'agency_profile' => [
    'text'  => 'Agency Profile',
    'icon'  => 'mdi mdi-contacts',
    'route' => 'agency_admin.profile',
    ],
    'escorts' => [
    'text' => 'Escorts',
    'icon' => 'mdi mdi-account-multiple',
    'route' => 'agency_admin.escorts',
    ],
    'reviews' => [
    'text' => 'Reviews',
    'icon' => 'mdi mdi-format-quote',
    'route' => 'agency_admin.reviews',
    ],
    'email' => [
    'text' => 'Email',
    'icon' => 'mdi mdi-email',
    'route' => 'agency_admin.emails.manage'
    ],
    'followers' => [
      'text'  => 'Followers',
      'icon'  => 'mdi mdi-account-multiple-outline',
      'route' => 'agency_admin.followers',
    ],
    'account_settings' => [
      'text' => 'Account Settings',
      'icon' => 'mdi mdi-settings',
      'route' => 'agency_admin.account_settings'
    ],
    'logout' => [
      'text' => 'Logout',
      'icon' => 'mdi mdi-logout',
      'route' => 'agency_admin.auth.logout',
    ],
  ],
  'member_admin' => [
    'dashboard' => [
      'text' => 'Dashboard',
      'icon' => 'mdi mdi-gauge',
      'route' => 'member_admin.dashboard',
    ],
    'profile' => [
      'text'  => 'My Profile',
      'icon'  => 'mdi mdi-contacts',
      'route' => 'member_admin.profile',
    ],
    'favorite_escorts' => [
      'text'  => 'My Favorite Escorts',
      'icon'  => 'mdi mdi-gender-female',
      'route' => 'member_admin.favorite_escorts.manage',
    ],
    'favorite_agencies' => [
      'text'  => 'My Favorite Agency',
      'icon'  => 'mdi mdi-tie',
      'route' => 'member_admin.favorite_agencies.manage',
    ],
    'reviews' => [
      'text'  => 'Reviews',
      'icon'  => 'mdi mdi-format-quote',
      'route' => 'member_admin.reviews',
    ],
    'comments' => [
      'text'  => 'Comments',
      'icon'  => 'mdi mdi-comment',
      'route' => 'member_admin.comments',
    ],
    'email' => [
      'text' => 'Email',
      'icon' => 'mdi mdi-email',
      'route' => 'member_admin.emails.manage'
    ],
    'account_settings' => [
      'text' => 'Account Settings',
      'icon' => 'mdi mdi-settings',
      'route' => 'member_admin.account_settings'
    ],
    'logout' => [
      'text' => 'Logout',
      'icon' => 'mdi mdi-logout',
      'route' => 'member_admin.auth.logout',
    ],
  ],
];
