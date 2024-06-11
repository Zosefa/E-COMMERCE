<?php

namespace App\Security;

use App\Repository\UserRepository;
use SebastianBergmann\Type\FalseType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    public function __construct(private UrlGeneratorInterface $urlGenerator,private readonly UserRepository $repository)
    {
    }

    public function supports(Request $request): bool
    {
        if($request->isMethod('POST')){
            $username = $request->request->get('username', '');
            $user = $this->repository->findAll();
            foreach ($user as $value) {
                if($username == $value->getUsername()){
                    $active = $this->repository->getEtat($username);
                    if($active){
                        return $active;
                    }else{
                        return false;
                    }
                }
            } 
            
            return false;         
        }    
        else{
            return false;
        } 
    }

    public function authenticate(Request $request): Passport
    {
        $username = $request->request->get('username', '');
        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $username);
            return new Passport(
                new UserBadge($username),
                new PasswordCredentials($request->request->get('password', '')),
                [
                    new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
                    new RememberMeBadge(),
                ]
            );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
        //     return new RedirectResponse($targetPath);
        // }
        $username = $request->request->get('username');
        $role= $this->repository->getRole($username);

        if($role == '["ROLE_CLIENT"]'){
            return new RedirectResponse($this->urlGenerator->generate('boutique_index'));
            throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
        } else if($role == '["ROLE_VENDEUR"]'){
            return new RedirectResponse($this->urlGenerator->generate('app_produit_liste'));
            throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
        } else {
            return new RedirectResponse($this->urlGenerator->generate('dashboard'));
            throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
        }   
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
