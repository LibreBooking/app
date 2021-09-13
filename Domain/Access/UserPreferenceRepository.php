<?php

require_once(ROOT_DIR . 'Domain/User.php');

interface IUserPreferenceRepository
{
    /**
     * @abstract
     * @param $userId int
     * @return array|string[] values, indexed by name
     */
    public function GetAllUserPreferences($userId);

    /**
     * @abstract
     * @param $userId int
     * @param $preferenceName string
     * @return string|null
     */
    public function GetUserPreference($userId, $preferenceName);

    /**
     * @abstract
     * @param $userId int
     * @param $preferenceName string
     * @param $preferenceValue string
     * @return void
     */
    public function SetUserPreference($userId, $preferenceName, $preferenceValue);
}

class UserPreferenceRepository implements IUserPreferenceRepository
{
    /**
     * @param $userId int
     * @return array|string[] values, indexed by name
     */
    public function GetAllUserPreferences($userId)
    {
        $reader = ServiceLocator::GetDatabase()->Query(new GetUserPreferencesCommand($userId));

        $rv = [];
        while ($row = $reader->GetRow()) {
            $rv[$row[ColumnNames::PREFERENCE_NAME]] = $row[ColumnNames::PREFERENCE_VALUE];
        }

        $reader->Free();
        return $rv;
    }

    /**
     * @param $userId int
     * @param $preferenceName string
     * @return string|null
     */
    public function GetUserPreference($userId, $preferenceName)
    {
        $reader = ServiceLocator::GetDatabase()->Query(new GetUserPreferenceCommand($userId, $preferenceName));

        if ($row = $reader->GetRow()) {
            $reader->Free();
            return $row[ColumnNames::PREFERENCE_VALUE];
        }

        $reader->Free();
        return null;
    }

    /**
     * @param $userId int
     * @param $preferenceName string
     * @param $preferenceValue string
     * @return void
     */
    public function SetUserPreference($userId, $preferenceName, $preferenceValue)
    {
        $db = ServiceLocator::GetDatabase();

        $existingValue = self::GetUserPreference($userId, $preferenceName);
        if (is_null($existingValue)) {
            $db->ExecuteInsert(new AddUserPreferenceCommand($userId, $preferenceName, $preferenceValue));
        } elseif ($existingValue != $preferenceValue) {
            $db->Execute(new UpdateUserPreferenceCommand($userId, $preferenceName, $preferenceValue));
        }
    }
}
