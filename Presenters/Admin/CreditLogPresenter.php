<?php

class CreditLogPresenter
{
    /**
     * @var ICreditLogPage
     */
    private $page;
    /**
     * @var ICreditRepository
     */
    private $creditRepository;
    /**
     * @var IUserRepository
     */
    private $userRepository;

    public function __construct(ICreditLogPage $page, ICreditRepository $creditRepository, IUserRepository $userRepository)
    {
        $this->page = $page;
        $this->creditRepository = $creditRepository;
        $this->userRepository = $userRepository;
    }

    public function PageLoad(UserSession $userSession)
    {
        $userId = $this->page->GetUserId();
        $currentUser = $this->userRepository->LoadById($userSession->UserId);
        $searchUser = $this->userRepository->LoadById($userId);

        if (!empty($userId) && $currentUser->IsAdminFor($searchUser)) {
            $credits = $this->creditRepository->GetList($this->page->GetPageNumber(), $this->page->GetPageSize(), $userId);
            $this->page->BindCredits($credits->Results());
            $this->page->BindPageInfo($credits->PageInfo());
            $this->page->BindUserName($searchUser->FullName());
        } else {
            $this->page->ShowError();
        }
    }
}
